builddir              = ./build
vendor                = ./vendor/
phpcs                 = $(builddir)/mrsatik-phpcs.phar
phpcbf                = $(builddir)/mrsatik-phpbf.phar
target                = phpcs phpcbf
installdir            = /usr/local/bin
phpcs_install_target  = $(installdir)/mrsatik-phpcs
phpcbf_install_target = $(installdir)/mrsatik-phpcbf
composer              = $(shell which composer)
php                   = $(shell which php)

all:
	$(MAKE) clean-vendor $(target) COMPOSER_FLAGS="--no-dev -o"
	$(MAKE) $(vendor) -B

$(target): $(vendor) $(builddir)
	$(php) -d 'phar.readonly=0' scripts/build_phar.php --script=$@ --target=$($@)
	chmod a+x $($@)

$(builddir):
	mkdir -p $(builddir)

$(vendor):
	$(php) -d 'allow_url_fopen = 1' $(composer) install $(COMPOSER_FLAGS)

test: $(vendor)
	$(php) -d short_open_tag=On $(vendor)/bin/phpunit tests/

install: $(phpcs_install_target) $(phpcbf_install_target)

$(phpcs_install_target):
	cp $(phpcs) $(phpcs_install_target)

$(phpcbf_install_target):
	cp $(phpcbf) $(phpcbf_install_target)

uninstall:
	rm $(phpcs_install_target) $(phpcbf_install_target)

clean-all: clean clean-vendor

clean:
	rm -fr $(builddir)

clean-vendor:
	rm -fr $(vendor)
