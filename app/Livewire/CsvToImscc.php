<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use File;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class CsvToImscc extends Component
{
    use WithFileUploads;
    public $csv;

    public $text = '';
    public $displayDownload = false;

   public function createTemporaryDirectory($userId) {
        $sessionId = session()->getID();
        $directory = "tmp/{$userId}_{$sessionId}/output/lti/";
    
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory); // Creates a directory if it doesn't exist
        }
    
        return $directory;
    }

    public function convert()
    {

        //dd(auth()->id());
       // Validate the uploaded file
       $this->validate([
        'csv' => 'required|file|mimes:csv,txt', 
        ]);

        // Load the CSV file
        $path = $this->csv->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $sessionId = session()->getID();
        $userId = auth()->id();

        
        // Skip the header row if your CSV has headers
        $resourcesDir= $this->createTemporaryDirectory($userId);

        //dd($resourcesDir);
        $existingOutput = Storage::allDirectories($resourcesDir);
        foreach ($existingOutput as $directory) {
            Storage::deleteDirectory($directory);
        }
        Storage::delete('output/imsmanifest.xml');

        $count = 0;

        foreach ($data as $row) {

            $title = $row[0];
            $url = $row[1];
            
            $resourceDir = $resourcesDir . 'resource_' . ($count);
            Storage::makeDirectory($resourceDir);

            // Generate XML content
            $xmlContent = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
            $xmlContent = "<cartridge_basiclti_link xmlns=\"http://www.imsglobal.org/xsd/imslticc_v1p3\" xmlns:blti=\"http://www.imsglobal.org/xsd/imsbasiclti_v1p0\" xmlns:lticm=\"http://www.imsglobal.org/xsd/imslticm_v1p0\" xmlns:lticp=\"http://www.imsglobal.org/xsd/imslticp_v1p0\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.imsglobal.org/xsd/imslticc_v1p3 http://www.imsglobal.org/xsd/lti/ltiv1p3/imslticc_v1p3.xsd                      http://www.imsglobal.org/xsd/imslticp_v1p0 http://www.imsglobal.org/xsd/lti/ltiv1p0/imslticp_v1p0.xsd                      http://www.imsglobal.org/xsd/imslticm_v1p0 http://www.imsglobal.org/xsd/lti/ltiv1p0/imslticm_v1p0.xsd                      http://www.imsglobal.org/xsd/imsbasiclti_v1p0 http://www.imsglobal.org/xsd/lti/ltiv1p0/imsbasiclti_v1p0p1.xsd\">\n";
            $xmlContent .= "<blti:title>" . htmlspecialchars($title) . "</blti:title>\n";
            $xmlContent .= "<blti:description></blti:description>\n";
            $xmlContent .= "<blti:launch_url>" . htmlspecialchars($url) . "</blti:launch_url>\n";
            $xmlContent .= "<blti:vendor>\n";
            $xmlContent .= "<lticp:code>D2L</lticp:code>\n";
            $xmlContent .= "<lticp:name>Brightspace</lticp:name>\n";
            $xmlContent .= "</blti:vendor>\n";
            $xmlContent .= "</cartridge_basiclti_link>";

            // Define file name and path for the XML
            $fileName = 'resource.xml';

            // Save the XML file to storage
            Storage::disk('local')->put($resourceDir . '/' . $fileName, $xmlContent);
            $count++;
        }

        // Provide feedback to the user
        session()->flash('message', 'CSV data successfully converted to XML files.');

        $manifestContent = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $manifestContent .= "<manifest identifier=\"ia2d20770-5545-40f8-9de0-e21398276011\" xmlns=\"http://www.imsglobal.org/xsd/imsccv1p3/imscp_v1p1\" xmlns:lomr=\"http://ltsc.ieee.org/xsd/imsccv1p3/LOM/resource\" xmlns:lomm=\"http://ltsc.ieee.org/xsd/imsccv1p3/LOM/manifest\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://ltsc.ieee.org/xsd/imsccv1p3/LOM/resource http://www.imsglobal.org/profile/cc/ccv1p3/LOM/ccv1p3_lomresource_v1p0.xsd http://www.imsglobal.org/xsd/imsccv1p3/imscp_v1p1 http://www.imsglobal.org/profile/cc/ccv1p3/ccv1p3_imscp_v1p2_v1p0.xsd http://ltsc.ieee.org/xsd/imsccv1p3/LOM/manifest http://www.imsglobal.org/profile/cc/ccv1p3/LOM/ccv1p3_lommanifest_v1p0.xsd\">\n";
        $manifestContent .= "<metadata>\n";
        $manifestContent .= "<schema>IMS Common Cartridge</schema>\n";
        $manifestContent .= "<schemaversion>1.3.0</schemaversion>";
        $manifestContent .= "<lomm:lom>\n";
        $manifestContent .= "<lomm:general>\n";
        $manifestContent .= "<lomm:title>\n";
        $manifestContent .= "<lomm:string language=\"en-US\">Career Planning - MSTR-17a</lomm:string>\n";
        $manifestContent .= "</lomm:title>\n";
        $manifestContent .= "</lomm:general>\n";
        $manifestContent .= "</lomm:lom>\n";
        $manifestContent .= "</metadata>\n";
        $manifestContent .= "<organizations>\n";
        $manifestContent .= "<organization>\n";
        $manifestContent .= "<item identifier=\"i8314392d-94af-45b5-b9e8-bb11b10098ba\" />\n";
        $manifestContent .= "<metadata>\n<lomm:lom />\n</metadata>\n";
        $manifestContent .= "</organization>\n";
        $manifestContent .= "</organizations>\n";
        $manifestContent .= "<resources>\n";

        foreach ($data as $index => $resource) {
            $manifestContent .= "<resource identifier=\"resource_" . ($index + 1) . "\" type=\"imsbasiclti_xmlv1p3\">\n";
            $manifestContent .= "<file href=\"lti/resource_" . ($index + 1) . "/resource.xml\" />\n";
            $manifestContent .= "</resource>\n";
        }

        $manifestContent .= "</resources>\n";
        $manifestContent .= "</manifest>";

        // Save the imsmanifest.xml file
        file_put_contents('imsmanifest.xml', $manifestContent);
        Storage::disk('local')->put('tmp/'. $userId .'_'. $sessionId .'/output/imsmanifest.xml', $manifestContent);
        $this->zipDirectory(storage_path('app/tmp/' . $userId .'_'. $sessionId . '/output/'), storage_path('app/tmp/' . $userId .'_'. $sessionId . '/cartridge.imscc'));
        $this->displayDownload = true;
    }

    public function zipDirectory($sourceDir, $outZipPath)
    {
       // Initialize archive object
    $zip = new ZipArchive();
    $zip->open($outZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    // Create recursive directory iterator
    /** @var SplFileInfo[] $files */
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($sourceDir),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file) {
        // Skip directories (they would be added automatically)
        if (!$file->isDir()) {
            // Get real and relative path for current file
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($sourceDir));

            // Add current file to archive
            $zip->addFile($filePath, $relativePath);
        }
    }

    // Zip archive will be created only after closing object
    return $zip->close();
    }

    public function download()
    {
        $sessionId = session()->getID();
        $userId = auth()->id();
        
        return Storage::download('tmp/' . $userId . '_' . $sessionId . '/cartridge.imscc');
    }

    public function render()
    {
        return view('livewire.csv-to-imscc');
    }

}
