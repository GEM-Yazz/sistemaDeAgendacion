(function(global){
	global.$_Tawk_AccountKey='64bb56b2cc26a871b02a6be8';
	global.$_Tawk_WidgetId='1h5tslann';
	global.$_Tawk_Unstable=false;
	global.$_Tawk = global.$_Tawk || {};
	(function (w){
	function l() {
		if (window.$_Tawk.init !== undefined) {
			return;
		}

		window.$_Tawk.init = true;

		// var files = [
    //   'https://lg-agendamiento.pruebascircuit.com/wp-content/themes/lg-agendamiento/app/static/public/js/app.b1cc69c9.js',
    //   'https://lg-agendamiento.pruebascircuit.com/wp-content/themes/lg-agendamiento/app/static/public/js/chunk-vendors.6ae67b23.js',
    //   'https://lg-agendamiento.pruebascircuit.com/wp-content/themes/lg-agendamiento/app/static/public/js/home.ba421689.js',
		// ];

    // var styles = [
    //   'https://lg-agendamiento.pruebascircuit.com/wp-content/themes/lg-agendamiento/app/static/public/css/app.e3b7a85a.css',
    //   'https://lg-agendamiento.pruebascircuit.com/wp-content/themes/lg-agendamiento/app/static/public/css/chunk-vendors.3b661707.css',
		// ];

		// var s0=document.getElementsByTagName('script')[0];

    // let body = document.getElementsByTagName('body')[0];
    // let main = document.createElement('main');
    // main.id= "app";
    // main.classList.add('c-main')
    // body.appendChild(main);

    // let iframe = document.createElement('iframe');
    // iframe.src = "https://comparalg.com/";
    // // iframe.width = "500";
    // // iframe.height = "300";
    // iframe.frameBorder = "0";
    // iframe.allowFullscreen = true;

    // body.appendChild(iframe);

    // let base = document.getElementsByClassName('c-main')[0];

    // for (var i = 0; i < styles.length; i++) {
		// 	var l1 = document.createElement('link');
		// 	l1.href= styles[i];
		// 	l1.rel='stylesheet';
		// 	l1.setAttribute('crossorigin','*');
		// 	s0.parentNode.insertBefore(l1,s0);
		// }

		// for (var i = 0; i < files.length; i++) {
		// 	var s1 = document.createElement('script');
		// 	s1.src= files[i];
		// 	s1.charset='UTF-8';
		// 	s1.setAttribute('crossorigin','*');
		// 	s0.parentNode.insertBefore(s1,s0);
		// }

    let body = document.getElementsByTagName('body')[0];

    let iframe = document.createElement('iframe');
    iframe.src = "https://lg-agendamiento.pruebascircuit.com/";
    // iframe.width = "300";
    // iframe.height = "518";
    iframe.frameBorder = "0";


    if (window.innerWidth <= 600) {
      iframe.style.cssText = `
      position: fixed;
      bottom: 0;
      right: 0;
      z-index: 1000;
      box-shadow: 0 4px 4px rgba(0,0,0,.27058823529411763);
      width: 100%;
      height: 100vh`;
    } else {
      iframe.style.cssText = `
      position: fixed;
      bottom: 115px;
      right: 10px;
      z-index: 999;
      box-shadow: 0 4px 4px rgba(0,0,0,.27058823529411763)
      width: 300px;
      height: 518px`;
    }

    iframe.style.display = 'none'
    iframe.allowFullscreen = true;
    body.appendChild(iframe);

    let button = document.createElement('button');
    button.style.cssText = `
      bottom: 10px;
      right: 10px;
      position: fixed;
      z-index: 1000;
      border: 0;
      width: 242px;
      height: 70px;
      border-radius: 10px;
      padding: 10px;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 30px;
      z-index: 999;
      background-image: url(https://mailing.pruebascircuit.com/lg-agendamiento/chat-m.png);
      background-position: center;
      background-size: 98%;
      background-repeat: no-repeat;
      background-color: transparent;
    `;
    button.type = 'button';
    body.appendChild(button);

    button.addEventListener('click', ()=> {
      if(iframe.style.display === 'none') {
        iframe.style.display = 'block'
        if (window.innerWidth <= 600) {
          close.style.display = 'flex'
        }
      } else {
        iframe.style.display = 'none'
      }
    })

    let close = document.createElement('button');
    close.style.cssText = `
      bottom: 10px;
      right: 10px;
      position: fixed;
      z-index: 1001;
      border: 0;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 20px;
      background: #a50034;
      display: none
    `;
    close.type = 'button';
    close.innerHTML = '✕'
    body.appendChild(close);
    close.addEventListener('click', ()=> {
      iframe.style.display = 'none';
      close.style.display = 'none'
    })
	}
	if (document.readyState === 'complete') {
		l();
	} else if (w.attachEvent) {
		w.attachEvent('onload', l);
	} else {
		w.addEventListener('load', l, false);
	}
})(window);

})(window);
