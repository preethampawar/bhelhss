_c.config = {
	popup: {
		captionEl: false, // show popup caption
		caption_hide: false, // Auto-hide popup caption on mouse inactivity
	},
	theme: {
		themes: ['contrast', 'light', 'dark'], // array of available themes for button switch
		default: 'light', // default theme when no theme is previously selected
		button: true, // allow button to switch themes
		auto: true, // allow prefers-color-scheme:dark
	},
	// panorama options
	panorama: {
		// function to detect panorama equirectangular source file
		is_pano: (item) => {
			const d = item.dimensions;
			// >=2048px && ratio 2:1 with 1% pixel margin
			return d[0] >= 2048 && Math.abs(d[0] / d[1] - 2) < 0.01;
		},
	},
}
