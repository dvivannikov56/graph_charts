let tab = function () {
	let tabNav = document.querySelectorAll('.tabs-nav__item'),
	tabContent = document.querySelectorAll('.tab'),tabName;
	tabNav.forEach(item=> {
		item.addEventListener('click',selectTabNav)
	});
	function selectTabNav() {
		tabNav.forEach(item=> {
		item.classList.remove('is-active')
	});
		this.classList.add('is-active');
		tabName = this.getAttribute('tab-name');     // Append <li> to <ul> with id="myList"
		selectTabContent(tabName);
	}
	
function selectTabContent(tabName) {
	tabContent.forEach(item=> {
		item.classList.contains(tabName) ? item.classList.add('is-active') : item.classList.remove('is-active')
	});
}
};

tab();