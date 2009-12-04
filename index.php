<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>tinyMy: small mysql console in PHP</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
  * {
    margin: 0;
    padding: 0;
  }
  body, html {
    font-family: trebuchet ms, verdana, sans-serif;
  }
  h1 {
    background-color: #6F6DC6;
    color: #ffffff;
    margin-bottom: 10px;
    padding: 10px 10px 3px 10px;
    border-bottom: 3px solid #339;
  }
  ul.nob {
    list-style: none;
    margin-bottom: 20px;
    margin-left: 30px;
  }

  h2 {
    margin-left: 20px;
    margin-top: 20px;
  }

  p {
    margin: 10px 50px 10px 40px;
    text-align: justify;
  }
  div#news {
    float: right;
    border: 1px solid #339;
    padding: 10px;
    margin-right: 10px;
    margin-left: 20px;
    background-color: #f3f3ff;
    width: 400px;
  }
  div#news h3 {
    font-size: 16px;
    margin: 0 0 10px 0;
    text-decoration: underline;
    color: #339;
  }
  div#news h4 {
    font-size: 12px;
    margin: 0;
  }
  div#news p {
    margin: 0 0 10px 10px;
    font-size: 80%;
  }
  div#foot {
    border-top: 1px solid #bbb;
    color: #bbb;
    text-align: right;
    padding: 10px;
    margin: 20px;
  }


</style>
</head>
<body>
  <h1>tinyMy: small mysql console</h1>
  <ul class="nob">
    <li><a href="tinymy.zip"><strong>Download TinyMy</strong> (7kb .zip) &raquo;</a></li>
    <li><a href="tinymy.tar.gz"><strong>Download TinyMy</strong> (7kb .tar.gz) &raquo;</a></li>
  </ul>
  <h2>Word of advice</h2>
  <p>As I have stopped the development of tinymy, if you need more options and/or postgresql support, I suggest you to check out <a href="http://www.gosu.pl/dbkiss/">DBKiss database browser</a> by Cezary Tomczak. It's great.</p>
  <h2>What's this?</h2>
  <p>A minimalist mysql console to manage mysql server over web.</p>
  <p>Usually to manage mysql server over the web, <a href="http://www.phpmyadmin.net/">phpMyAdmin</a> is used. Being really great product, it is somehow big, I don't need most of its features, and is waaaay too heavy to be used comfortably over dial-up or another slow connection. Generally, all I usually need is a small mysql console plus the overview of databases and tables, and that's why this little app was born.</p>
  <p>If you need fancy wizards, or you are not intimately familiar with SQL language, or blank console scares you, I don't think this app will help you.</p>
  <p>You can see a sample output from this app as static html <a href="sample.html">here</a>. Sure enough, I won't give you access to this mysql for live test.</p>
  <h2>What do I need to use tinymy?</h2>
  <p>You need access to web server with PHP (version doesn't really matter, it should work with any decent php version) with mysql libraries and session management enabled. You obviously need a mysql server for managing, too.</p>
  <p>This app is error_reporting, register_globals, magic_quotes, short_open_tag and all-that-stuff safe (E_STRICT doesn't pass for backwards compatibility, though), so I doubt that you will run into configuration issues, though it's possible that I've overlooked something.</p>
  <h2>Possible problems?</h2>
  <p>Your user name and password are stored in the session variables for the duration of the session. Depending on various settings, your system may choose to store the session data under /tmp or other place freely accessible for all users. Know what you are doing.</p>
  <p>If you use some fancy character encoding other than UTF-8, non-english characters will probably be displayed as garbage (you can work around it by changing character set for Content-Type in the php file, though).</p>
  <h2>Any license agreement or something?</h2>
  <p>This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/2.5/">Creative Commons Attribution 2.5 License</a>. </p>
  <p>Mostly that means something like &quot;I don't give a damn about the legal stuff, so feel free to do whatever you want to do with it.&quot;</p>
  <p><a rel="license" href="http://creativecommons.org/licenses/by/2.5/"><img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.png"/></a>
<!-- <rdf:RDF xmlns="http://web.resource.org/cc/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
<Work rdf:about="">
  <license rdf:resource="http://creativecommons.org/licenses/by/2.5/" />
</Work>
<License rdf:about="http://creativecommons.org/licenses/by/2.5/"><permits rdf:resource="http://web.resource.org/cc/Reproduction"/><permits rdf:resource="http://web.resource.org/cc/Distribution"/><requires rdf:resource="http://web.resource.org/cc/Notice"/><requires rdf:resource="http://web.resource.org/cc/Attribution"/><permits rdf:resource="http://web.resource.org/cc/DerivativeWorks"/></License></rdf:RDF> -->
  </p>
  <h2>Contacts</h2>
  <p>Einar Lielmanis, einars@gmail.com</p>
  <div id="foot">&copy; 2004-2008, elfz</div>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
</body>
</html>
