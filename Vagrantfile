Vagrant.configure("2") do |config|

  config.vm.box = "ubuntu/trusty64"

  config.vm.network :private_network, ip: "192.168.14.14"

  config.vm.synced_folder ".", "/vagrant", type: "nfs", id: "fictionar"

  config.vm.provision :shell do |shell|
    shell.inline = "
      mkdir -p /etc/puppet/modules;
      ( puppet module list | grep puppetlabs-mysql ) || ( puppet module install puppetlabs/mysql );
      ( puppet module list | grep willdurand-composer ) || ( puppet module install willdurand/composer );
      ( puppet module list | grep puppetlabs-apt ) || ( puppet module install puppetlabs/apt );
      ( puppet module list | grep camptocamp-augeas ) || ( puppet module install camptocamp/augeas );
      sudo curl -LsS http://symfony.com/installer -o /usr/local/bin/symfony;
      sudo chmod a+x /usr/local/bin/symfony;
    "
  end

  config.vm.provision :puppet do |puppet|
    puppet.manifests_path = 'puppet/manifests'
    puppet.module_path = 'puppet/modules'
    puppet.manifest_file = 'init.pp'
  end

  config.vm.provider :virtualbox do |vb|
    vb.customize ["modifyvm", :id, "--memory", "2048"]
    vb.customize ["modifyvm", :id, "--cpus", "2"]
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
  end

  config.vm.hostname = "fictionar.ro"
  config.hostsupdater.aliases = ["www.fictionar.ro"]

end
