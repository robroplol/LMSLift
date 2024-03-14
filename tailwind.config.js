import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                heading: [
                    "Montserrat",
                    "Roboto",
                    ...defaultTheme.fontFamily.sans,
                ],
                body: ["Poppins", "Roboto", ...defaultTheme.fontFamily.sans],
                logo: [
                    "Lilita One",
                    "Montserrat",
                    "Roboto",
                    ...defaultTheme.fontFamily.sans,
                ],
            },
            colors: {
                primary: "#ab9ac1",
                secondary: "#ab9ac1",
                accent: "#A9D2D5",
                raisin: "#211A1E",
                highlight: "#DAA520",
                charcoal: "#333333",
                navy: "#000080",
            },
        },
    },
    plugins: [forms],
};
