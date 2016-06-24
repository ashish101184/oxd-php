<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div id="dokuwiki__site">

    <div id="dokuwiki__top" class="dokuwiki site mode_show  ">
        <div class="">
            <div class="pad group">
                <div class="page group">
                    <h3>https://client.example.com demo site for oxd-rp-php library.</h3>
                    <p>How to see demo site. </p>
                    <p> Copy client.example.com folder in your web server root folder (for example xampp/htdocs/).</p>
                    <p>  Configure with following code in httpd-vhosts.config present in C:/xampp/apache/config/extra/ .</p>
<pre class="lang-php prettyprint prettyprinted">
<code>
<span class="tag">&lt;VirtualHost</span><span class="pln"> *:443</span><span class="tag">&gt;</span><span class="pln">
    ServerAdmin postmaster@dummy-host.localhost
    DocumentRoot "C:/xampp/htdocs/client.example.com/"
    ServerName client.example.com
    ServerAlias www.client.example.com
    SSLEngine on
    SSLCertificateFile "conf/ssl.crt/server.crt"
    SSLCertificateKeyFile "conf/ssl.key/server.key"
        &lt;Directory "C:\xampp\htdocs\client.example.com\ &gt;
            AllowOverride All
            Order allow,deny
            Allow from all
        </span><span class="tag">&lt;/Directory&gt;</span><span class="pln"> </span>
<span class="tag">&lt;/VirtualHost&gt;</span>
<span class="pln">    </span>
</code>
</pre>
                    <p>  Open file '%windir%\system32\drivers\etc\hosts' and add these line at end of file .</p>
                    <pre class="lang-php prettyprint prettyprinted">
127.0.0.1    client.example.com
                    </pre>
                    <p>  Restart web server apache and open in browser <a href="https://client.example.com" >client.example.com</a> .</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>