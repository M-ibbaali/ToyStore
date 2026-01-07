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
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#FFD700", // Bright Yellow
                secondary: "#1E90FF", // Bright Blue
                "toys-bg": "#FFFDE7", // Very Light Yellow
                "toys-text": "#102A43", // Deep Blue
                "toys-btn": "#1E90FF", // Blue Button
                "toy-yellow": "#FFD700",
                "toy-blue": "#1E90FF",
                "toy-red": "#FF5252",
            },
        },
    },

    plugins: [forms],
};
