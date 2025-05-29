$(document).ready(function () {
	// Hide all BHK select dropdowns initially
	// $('.bhkSelect').hide();

	$(document).on('input', '.property_search', function () {
		const $searchInput = $(this);
		const query = $searchInput.val().trim();
		const $container = $searchInput.closest('.search-container');
		const $resultsList = $container.find('.autocomplete-results');
		const $bhkSelect = $container.find('.bhkSelect');

		if (query.length >= 1) {
			$.ajax({
				url: 'ajax/search_property.php',
				type: 'GET',
				dataType: 'json',
				data: {
					term: query
				},
				success: function (data) {
					if (data.length > 0) {
						const suggestions = data.map(item =>
							`<li class="autocomplete-item" data-name="${item.product_name}">
                                <a href="#">${item.product_name}</a>
                            </li>`

						);
						console.log(data)
						$resultsList.html(suggestions.join('')).show();

					} else {
						$resultsList.html('<li>No results found</li>').show();
						$bhkSelect.hide();
					}
				},
				error: function (xhr, status, error) {
					console.error(`AJAX error: ${status} - ${error}`);
				}
			});
		} else {
			$resultsList.hide();
			$bhkSelect.hide();
		}
	});

	// Handle click event for autocomplete suggestions
	$(document).on('click', '.autocomplete-item', function (e) {
		e.preventDefault();
		const selectedName = $(this).data('name');
		const $container = $(this).closest('.search-container');

		$container.find('.property_search').val(selectedName);
		$container.find('.autocomplete-results').hide();
		//			$('.bhkSelect').show();
	});
});


document.addEventListener("DOMContentLoaded", function () {
	const bhkSelect = document.getElementById('bhkSelect');
	if (bhkSelect) {
		bhkSelect.addEventListener('change', function () {
			const url = this.value;
			if (url) {
				window.open(url, '_blank');
			}
		});
	}
});

document.addEventListener("DOMContentLoaded", function () {
	const buttons = document.querySelectorAll(".floor-btn");
	const contents = document.querySelectorAll(".floor-content");

	buttons.forEach(btn => {
		btn.addEventListener("click", function () {
			const floorId = this.getAttribute("data-floor-id");

			contents.forEach(div => div.style.display = "none"); const target = document.getElementById("floor-content-" + floorId);
			if (target) {
				target.style.display = "inline-block";
			}
		});
	});
});


document.addEventListener("DOMContentLoaded", function () {
	document.querySelectorAll('.ff').forEach(function (el) {
		el.style.display = 'none';
	});

	document.querySelectorAll('.toggle-ff').forEach(function (btn) {
		btn.addEventListener('click', function (e) {
			e.preventDefault();
			const targetIds = this.getAttribute('data-target')?.split(',');
			if (targetIds) {
				targetIds.forEach(function (id) {
					const el = document.getElementById(id.trim());
					if (el) {
						el.style.display = (el.style.display === 'none') ? 'block' : 'none';
					}
				});
			} else if (this.id === 'view-images-btn') {
				document.getElementById('image-link').click();
			}
		});
	});

	document.querySelectorAll('.view-image-btn').forEach(btn => {
		btn.addEventListener('click', function (e) {
			e.preventDefault();

			const imgSrc = this.getAttribute('data-image');
			const imgTitle = this.getAttribute('data-title');

			const tempLink = document.createElement('a');
			tempLink.href = imgSrc;
			tempLink.setAttribute('data-lightbox', 'property-group');
			tempLink.setAttribute('data-title', imgTitle);

			document.body.appendChild(tempLink);

			setTimeout(() => {
				tempLink.click();
				setTimeout(() => document.body.removeChild(tempLink), 1000);
			}, 10);
		});
	});
});



document.getElementById("openPopup").addEventListener("click", function (e) {
	e.preventDefault();
	document.getElementById("popupOverlay").style.display = "flex";
});

document.getElementById("closePopup").addEventListener("click", function () {
	document.getElementById("popupOverlay").style.display = "none";
});

window.addEventListener("click", function (e) {
	const popup = document.getElementById("popupOverlay");
	if (e.target === popup) {
		popup.style.display = "none";
	}
});

document.getElementById("openPopup")?.addEventListener("click", function (e) {
	e.preventDefault();
	document.getElementById("popupOverlay").style.display = "flex";
});

document.getElementById("closePopup").addEventListener("click", function () {
	document.getElementById("popupOverlay").style.display = "none";
});

document.getElementById("dimensionForm").addEventListener("submit", function (e) {
	e.preventDefault();

	document.getElementById("popupOverlay").style.display = "none";

	document.getElementById("cardOverlay").style.display = "flex";
});

window.addEventListener("click", function (e) {
	const cardOverlay = document.getElementById("cardOverlay");
	if (e.target === cardOverlay) {
		cardOverlay.style.display = "none";
	}
});


document.addEventListener('DOMContentLoaded', function () {
	const select = document.getElementById('courses_search_select');
	const courseCols = document.querySelectorAll('.course_col');
	function filterCourses(selected) {
		courseCols.forEach(col => {
			const courseType = col.getAttribute('data-course');
			if (selected === 'All Products' || selected === courseType) {
				col.style.display = 'block';
			} else {
				col.style.display = 'none';
			}
		});
	}
	filterCourses('All Products');
	select.addEventListener('change', function () {
		filterCourses(this.value);
	});
});

document.addEventListener("DOMContentLoaded", function() {
		document.querySelectorAll(".toggle-ff").forEach(function(link) {
			link.addEventListener("click", function(e) {
				e.preventDefault();

				var targetId = this.getAttribute("data-target");
				var targetElement = document.getElementById(targetId);

				if (targetElement) {
					const isHidden = window.getComputedStyle(targetElement).display === "none";
					targetElement.style.setProperty("display", isHidden ? "block" : "none", "important");
				}
			});
		});
	});