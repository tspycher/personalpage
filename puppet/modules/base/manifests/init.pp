class base {
  service { "iptables":
    ensure  => "stopped",
    enable => false,
  }
}
