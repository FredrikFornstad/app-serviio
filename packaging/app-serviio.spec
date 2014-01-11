
Name: app-serviio
Epoch: 1
Version: 1.4
Release: 1%{dist}
Summary: **serviio_app_name**
License: Free to use with limitations. Please see LICENCE.txt in source file or http://www.serviio.org/licence
Group: ClearOS/Apps
Packager: Fredrik Fornstad
Vendor: Petr Nejedly
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base

%description
**serviio_app_description**

%package core
Summary: **serviio_app_name** - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: serviio >= 1.4
Requires: serviio-WebUI >= 1.5.3
Requires: webconfig-php-mbstring >= 5.3.3
Requires: app-base-core >= 1:1.2.6

%description core
**serviio_app_description**

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/serviio
cp -r * %{buildroot}/usr/clearos/apps/serviio/

install -D -m 0644 packaging/Serviio.conf %{buildroot}/usr/clearos/sandbox/etc/httpd/conf.d/Serviio.conf
install -D -m 0644 packaging/serviio.php %{buildroot}/var/clearos/base/daemon/serviio.php

%post
logger -p local6.notice -t installer 'app-serviio - installing'

%post core
logger -p local6.notice -t installer 'app-serviio-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/serviio/deploy/install ] && /usr/clearos/apps/serviio/deploy/install
fi

[ -x /usr/clearos/apps/serviio/deploy/upgrade ] && /usr/clearos/apps/serviio/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-serviio - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-serviio-core - uninstalling'
    [ -x /usr/clearos/apps/serviio/deploy/uninstall ] && /usr/clearos/apps/serviio/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/serviio/controllers
/usr/clearos/apps/serviio/htdocs
/usr/clearos/apps/serviio/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/serviio/packaging
%dir /usr/clearos/apps/serviio
/usr/clearos/apps/serviio/deploy
/usr/clearos/apps/serviio/language
/usr/clearos/apps/serviio/libraries
%config(noreplace) /usr/clearos/sandbox/etc/httpd/conf.d/Serviio.conf
/var/clearos/base/daemon/serviio.php
