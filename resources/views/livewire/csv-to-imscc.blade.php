<div class="flex flex-col items-center">
    <h1 class="text-3xl text-center font-bold uppercase mb-8">Convert Your CSV to IMSCC</h1>
 

    <form wire:submit.prevent="convert" class="flex flex-col items-center ">
        <label for="file">Please upload your CSV file here:</label><input type="file" wire:model="csv" name="file" id="">
        @error('csv') <span class="error">{{ $message }}</span> @enderror

        <button type="submit" class="bg-white text-black font-bold hover:bg-slate-300 p-4 rounded-md">Convert</button>
    </form>
   @if ($displayDownload === true)
        <h2><a href="#" wire:click="download">Download Common Cartridge Package</a></h2>
   @endif
</div>


