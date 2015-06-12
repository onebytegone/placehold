if (window.jQuery === undefined) {
   var script = document.createElement( 'script' );
   script.src = 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js';
   script.onload = extractInfo;
   document.body.appendChild(script);
} else {
   extractInfo();
}

function extractInfo() {
   var userinfo = $('.owner-name').first();
   var name = userinfo.html();
   var creatorurl = userinfo.prop('href');
   var licence = $('.photo-license-url').first().attr('href');
   var url = window.location.href;
   var index = url.indexOf('/in/photolist');
   if (index > 0) {
      url = url.substr(0, index) + '/';
   }

   /*
   console.log('url: '+url);
   console.log('creator: '+name);
   console.log('creator url: '+creatorurl);
   console.log('licence: '+licence);
   */

   var json = {
      "file": "",
      "source": url,
      "licence": licence,
      "creator": name,
      "creator_link": creatorurl,
      "width": 0,
      "height": 0,
   };

   copyToClipboard(JSON.stringify(json, null, '   '));
}

function copyToClipboard(text) {
  window.prompt("Copy to clipboard:", text);
}
