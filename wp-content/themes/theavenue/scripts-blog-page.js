
window.addEventListener('load', (event) => {
		var featured = document.getElementById('bdpp-post-gridbox-1');
		if(window.innerWidth <= 900 && window.innerWidth > 640){
			if(featured.classList.contains('bdpp-design-8')){
				featured.classList.remove('bdpp-design-8');
				featured.classList.add('bdpp-design-6');
			}
		}
		if(window.innerWidth > 900){
			if(featured.classList.contains('bdpp-design-6')){
				featured.classList.remove('bdpp-design-6');
				featured.classList.add('bdpp-design-8');
			}
		}
		if(window.innerWidth < 640){
			if(featured.classList.contains('bdpp-design-6')){
				featured.classList.remove('bdpp-design-6');
				featured.classList.add('bdpp-design-8');
			}
		}

	window.addEventListener('resize', function(){
		var featured = document.getElementById('bdpp-post-gridbox-1');
		if(window.innerWidth <= 900 && window.innerWidth > 640){
			if(featured.classList.contains('bdpp-design-8')){
				featured.classList.remove('bdpp-design-8');
				featured.classList.add('bdpp-design-6');
			}
		}
		if(window.innerWidth > 900){
			if(featured.classList.contains('bdpp-design-6')){
				featured.classList.remove('bdpp-design-6');
				featured.classList.add('bdpp-design-8');
			}
		}
		if(window.innerWidth < 640){
			if(featured.classList.contains('bdpp-design-6')){
				featured.classList.remove('bdpp-design-6');
				featured.classList.add('bdpp-design-8');
			}
		}

	});
});	

//gridbox-8 classes: bdpp-post-grid-box-wrap bdpp-post-data-wrap bdpp-clearfix bdpp-design-8
//gridbox-6 classes: bdpp-post-grid-box-wrap bdpp-post-data-wrap bdpp-design-6  bdpp-clearfix