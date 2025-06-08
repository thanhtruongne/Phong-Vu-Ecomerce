/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.jsx",
        "./resources/**/*.vue",
        "./resources/**/*.ts",
        "./resources/**/*.tsx",
    ],
    theme: {
        extend: {
            colors: {
                // Bạn có thể thêm custom colors ở đây
            },
        },
    },
    plugins: [],
}
