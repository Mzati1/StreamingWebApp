/** @type {import('tailwindcss').Config} */
export default {
  content: [
		"./resources/**/*.blade.php",
		 "./resources/**/*.js",
		 "./resources/**/*.vue",
		 "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
	],
  theme: {
    extend: {
		width: {	
			'96' : '24rems'
		}
	},
  },
  plugins: [
		require("daisyui"),
	],
	daisyui: {
		themes: ["light", "dark"],
	},
}

