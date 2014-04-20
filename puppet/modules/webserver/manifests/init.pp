class webserver {
  exec { 'install_epel':
    command => "/bin/rpm -Uvh http://download.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm",
    creates => "/etc/yum.repos.d/epel.repo",
  }

  exec { 'install_remi':
    command => "/bin/rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm",
    creates => "/etc/yum.repos.d/remi.repo",
  }

  file { "/etc/yum.repos.d/epel.repo":
    ensure => present ,
    source => "puppet:///modules/webserver/etc/yum.repos.d/epel.repo",
    require => Exec["install_epel"],
  }

  file { "/etc/yum.repos.d/remi.repo":
    ensure => present ,
    source => "puppet:///modules/webserver/etc/yum.repos.d/remi.repo",
    require => Exec["install_remi"],
  }

  package { ["httpd", "php" ]:
    ensure  => present,
    require => File["/etc/yum.repos.d/remi.repo", "/etc/yum.repos.d/epel.repo"],
  }

  service { "httpd":
    ensure  => "running",
    require => Package["httpd"],
    enable => true,
    subscribe => File["/etc/httpd/conf/httpd.conf", "/etc/httpd/conf.d/page.conf"],
  }

  file { "/etc/php.ini":
    ensure => present,
    source => "puppet:///modules/webserver/etc/php.ini",
    require => Package["php"],
  }

  file { "/etc/httpd/conf.d/page.conf":
    ensure => present,
    source => "puppet:///modules/webserver/etc/httpd/conf.d/page.conf",
    require => Package["httpd"],
  }

  file { "/etc/httpd/conf/httpd.conf":
    ensure => present,
    source => "puppet:///modules/webserver/etc/httpd/conf/httpd.conf",
    require => Package["httpd"],
  }

  file { "/etc/httpd/conf.d/welcome.conf":
    ensure => absent,
    require => Package["httpd"],
  }

  file { "/var/lib/php/session":
    ensure => "directory",
    owner  => "vagrant",
    group  => "vagrant",
    require => Package["php"],
  }
}
