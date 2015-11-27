site_id = ARGV[0]

system("mkdir -p /home/rcms/#{site_id}/lib/langconfig/")
File::open("/home/rcms/#{site_id}/lib/langconfig/ja.php" , "w"){|f|
  f.write <<EOL
<?php
if(is_file(SITE_LIB_PATH."/config.php")){
  require_once(SITE_LIB_PATH."/config.php");
}
if(is_file("/home/rcms/.mylib.php")){
  require_once("/home/rcms/.mylib.php");
}
EOL
  f.flush
  f.close
}

File::open("/etc/ssh/ssh_config", "r+"){|f|
  content = f.read
  content.gsub!('#PubkeyAuthentication', 'PubkeyAuthentication')
  content.gsub!('#RSAAuthentication', 'RSAAuthentication')
  content.gsub!('#AuthorizedKeysFile', 'AuthorizedKeysFile')
  f.rewind
  f.write(content);
  f.flush
  f.close
}

File::open("/home/rcms/#{site_id}/lib/default.php", "r+"){|f|
  content = f.read
  content.gsub!('$display_errors = false;', '$display_errors = true;');
  content.gsub!('define("RCMS_DEV_MODE","0")','define("RCMS_DEV_MODE","1")')
  content.gsub!('define("SHOW_DEBUG_TOOL_BAR", false);','define("SHOW_DEBUG_TOOL_BAR", true);')
  f.rewind
  f.write(content);
  f.flush
  f.close
}

htaccess = <<EOF
<Files ~ "^.(htaccess|htpasswd)$">
deny from all
</Files>
php_value include_path "/home/rcms/#{site_id}/lib
php_value session.name RCMSSESS
EOF

File::open("/home/rcms/#{site_id}/html/.htaccess", "w"){|f|
  f.write(htaccess)
}

# begin
#   require 'rubygems'
#   require 'sqlite3'
#   smtp_param = "port::465\nfrom::mizuno@diverta.co.jp\nuser::mizuno@diverta.co.jp\npass::hiromizu\nprotocol::SMTP_AUTH"
#   db =  SQLite3::Database.new("/home/rcms/#{site_id}/db/site.db")
#   ps = db.prepare("UPDATE st_site_conf SET value = :val WHERE sys_nm = :name")
#   ps.execute('name'=>'MAIL_SEND_SMTP_SERVER', 'val'=>'ssl://smtp.gmail.com')
#   ps.execute('name'=>'mail_send_smtp_param', 'val'=>smtp_param)
#   ps.close
#   db.close
# rescue LoadError
# end
