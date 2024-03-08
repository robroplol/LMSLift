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
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "deep-teal": "#093c44",
                "dark-teal": "#115e6e",
                "light-teal": "#2f8d98",
                green: "#b5cd34",
                orange: "#f7941e",
                "dark-gray": "#414042",
                "light-gray": "#6d6e71",
                "ada-green": "#6a7f17",
                "ada-orange": "#ac6610",
            },
        },
    },
    darkMode: false,
    plugins: [forms],
};
