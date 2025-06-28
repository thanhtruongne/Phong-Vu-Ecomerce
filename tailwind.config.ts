import type { Config } from 'tailwindcss';

export default {
    content: [
        "./resources/views/app.blade.php",
        "./resources/app/**/*.{js,ts,jsx,tsx}",
    ],
    theme: {
        extend: {
            zIndex: {
                1000: "1000",
                2000: "2000",
                5000: "5000",
                5050: "5050",
            },
            borderColor: {
                primary: "rgb(20, 53, 195)"
            },
            textColor: {
                neutral: '#1d1d20'
            },

            backgroundColor: {
                primary: '#1435c3',
                purewhite: '#f7f7f8'
            },
            fontFamily: {
                sans: ['Roboto', 'sans-serif'],
            },
        },
    },
    plugins: [],
} satisfies Config;
