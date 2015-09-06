class php {
  package { [
    'php5-fpm',
    'php5-cli',
    'php5-curl',
    'php5-mysql',
    'php5-imagick',
  ]:
    ensure => present,
    require => Exec['apt-get update'],
  }

  service { 'php5-fpm':
    ensure => running,
    require => Package['php5-fpm'],
  }
}
