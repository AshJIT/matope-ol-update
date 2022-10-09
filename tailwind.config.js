const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                transparent: 'transparent',
                current: 'currentColor',
                'matope-green': "rgba(45,59,49,1)",
                'matope-tan': "#cbba86",
                'matope-lighttan': 'rgba(225,218,196,1)',
                'matope-darktan': '#a18667',
                'matope-darkertan': '#574733',
                'matope-brown': '#665348',
                'matope-lightbrown': 'rgba(210,199,176,1)',
                'matope-lightbrownalt': '#bfaea5',
                'matope-darkbrown': '#423c39',
            }
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            backgroundColor: ['checked'],
            borderColor: ['checked'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
