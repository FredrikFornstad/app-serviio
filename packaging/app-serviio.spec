
Name: app-serviio
Epoch: 1
Version: 1.6.1
Release: 1%{dist}
Summary: Serviio Media Server
License: Free to use with limitations. Please see LICENCE.txt in source file or http://www.serviio.org/licence
Group: ClearOS/Apps
Packager: Fredrik Fornstad
Vendor: Petr Nejedly
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base

%description
Serviio Media Server - Serviio is a free media server. It allows you to stream your media files (music, video or images) to renderer devices (e.g. a TV set, Bluray player, games console or mobile phone) on your connected home network. There is also a paid for Pro edition which further enhances the possibilities of sharing content in your connected household. Serviio works with many devices from your connected home (TV, Playstation 3, XBox 360, smart phones, tablets, etc.). It supports profiles for particular devices so that it can be tuned to maximise the device potential and/or minimize lack of media format playback support (via transcoding). Serviio is using the DLNA protocol to stream content to the renderering devices.

%package core
Summary: Serviio Media Server - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: serviio >= 1.6.1
Requires: webconfig-php-mbstring >= 5.3.3
Requires: app-base-core >= 1:1.2.6
Obsoletes: serviio-WebUI

%description core
Serviio Media Server - Serviio is a free media server. It allows you to stream your media files (music, video or images) to renderer devices (e.g. a TV set, Bluray player, games console or mobile phone) on your connected home network. There is also a paid for Pro edition which further enhances the possibilities of sharing content in your connected household. Serviio works with many devices from your connected home (TV, Playstation 3, XBox 360, smart phones, tablets, etc.). It supports profiles for particular devices so that it can be tuned to maximise the device potential and/or minimize lack of media format playback support (via transcoding). Serviio is using the DLNA protocol to stream content to the renderering devices.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/serviio
cp -r * %{buildroot}/usr/clearos/apps/serviio/

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
/var/clearos/base/daemon/serviio.php
