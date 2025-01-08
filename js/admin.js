( function() {

	function reqListener () {
		console.log( this.response );
	}

	// watch button
	const watchbutton = document.querySelector(".watch");
	if( watchbutton ) {
		watchbutton.addEventListener("click",function(e) {
			e.preventDefault();
			watchbutton.classList.toggle("checked");
			var watch = 0;
			if( watchbutton.classList.contains("checked") ) {
				watch = 1;
				watchbutton.innerHTML = 'Update alerts on';
			} else {
				watch = 0;
				watchbutton.innerHTML = 'Watch this page';
			}
			var request = new XMLHttpRequest();
			request.open('POST', ajax, true);
			request.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded;' );

			// bind our event listener to the "load" event.
			// "load" is fired when the response to our request is completed and without error.
			request.addEventListener( 'load', reqListener );
			request.send('action=watch_post&_ajax_nonce=' + nonce + '&id=' + post_id + '&watch=' + watch );
		});
	}

	// customize panel
	const customizepanel = document.querySelector(".customizer .panel");
	const customizepanelclose = document.querySelector(".customizer .panel .close");
	const customizebutton = document.querySelector(".customizer .toggle-panel");
	if( customizebutton ) {
		// reposition if cookie panel is in the way
		setTimeout( function() {
			const cky = document.querySelector(".cky-consent-container");
			if( cky && ! cky.classList.contains("cky-hide") ) {
				customizebutton.style.bottom = "5.5rem";
			}
		}, 800 );
		
		customizebutton.addEventListener("click",function(e) {
			e.preventDefault();
			customizepanel.classList.add("open");
		});	

		customizepanelclose.addEventListener("click",function(e) {
			e.preventDefault();
			customizepanel.classList.remove("open");
		});	

		// close panel on escape
		document.addEventListener("keydown",function(evt) {
			evt = evt || window.event;
			if( evt.keyCode == 27 ) {
				if( customizepanel && customizepanel.classList.contains("open") ) {
					customizepanelclose.click();
				}
			}
		});

		// checkbox fields
		const customizechecks = document.querySelectorAll(".customizer .panel input[type=checkbox]");
		if( customizechecks ) {
			const bodyclasschecks = ['transparent'];
			customizechecks.forEach( function( custchk ) {
				// update post setting on change (no save button)
				custchk.addEventListener("change",function(e) {
					var request = new XMLHttpRequest();
					var field = custchk.id;
					if( custchk.checked ) {
						var value = true;
					} else {
						var value = false;
					}
					request.open('POST', ajax, true);
					request.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded;' );
		
					// bind our event listener to the "load" event.
					// "load" is fired when the response to our request is completed and without error.
					request.addEventListener( 'load', reqListener );
					request.send('action=update_post_setting&_ajax_nonce=' + nonce + '&id=' + post_id + '&field=' + encodeURIComponent( field ) + '&value=' + encodeURIComponent( value ) );

					if( bodyclasschecks.indexOf( field ) != -1 ) {
						var bodyclass = document.body.classList;
						if( value ) {
							document.body.classList.add( field.replace('_','-') );
						} else {
							document.body.classList.remove( field.replace('_','-') );
						}
					}
				});
			});
		}

		// select fields
		const customizeselects = document.querySelectorAll(".customizer .panel select");
		if( customizeselects ) {
			const bodyclassselects = ['top_shadow','bottom_shadow'];
			customizeselects.forEach( function( custsel ) {
				// update post setting on change (no save button)
				custsel.addEventListener("change",function(e) {
					var request = new XMLHttpRequest();
					var field = custsel.id;
					var value = custsel.value;
					request.open('POST', ajax, true);
					request.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded;' );
		
					// bind our event listener to the "load" event.
					// "load" is fired when the response to our request is completed and without error.
					request.addEventListener( 'load', reqListener );
					request.send('action=update_post_setting&_ajax_nonce=' + nonce + '&id=' + post_id + '&field=' + encodeURIComponent( field ) + '&value=' + encodeURIComponent( value ) );

					if( bodyclassselects.indexOf( field ) != -1 ) {
						var bodyclass = document.body.classList;
						bodyclass.forEach( function( bc ) {
							if( bc.indexOf( field.replace('_','-') ) != -1 ) {
								document.body.classList.remove( bc );
							}
							document.body.classList.add( field.replace('_','-') + '-' + value );
						});
					}

				});
			});
		}

	}

})();