include nginx, php

exec { 'apt-get update':
  command => 'apt-get update',
  path    => '/usr/bin'
}

package { ['vim', 'nano', 'git']:
  ensure => present,
}

class { 'composer':
  auto_update => true,
}

class { '::mysql::server':
  root_password => 'root',
  remove_default_accounts => true,
  override_options => {
    'mysqld' => {
      'character_set_server' => 'utf8',
      'collation_server' => 'utf8_general_ci'
    }
  }
}

mysql::db { 'fictionar':
  user     => 'fictionar',
  password => 'fictionar',
  host     => '%',
  grant    => ['ALL'],
  charset  => 'utf8',
  collate  => 'utf8_general_ci'
}
#
#php::fpm::config { 'max_nesting':
#  file    => '/etc/php5/cli/conf.d/20-xdebug.ini',
#  config  => [
#    'set .anon/xdebug.max_nesting_level 150'
#  ]
#}
#
#php::fpm::config { 'php timezone':
#  setting => 'date.timezone',
#  value => 'Europe/Berlin',
#  file    => '/etc/php5/fpm/php.ini',
#  section => 'Date'
#}
