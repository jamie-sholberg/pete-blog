<?
// —— PHP connection components
define ("DB_USER","jshol16");
define ("DB_PASSWORD","Madison79!");
define ("DB_HOST","mysql.jamiesholberg.com");
define ("DB_NAME","jamiesholberg"); 

// —— MYSQLi connection method
$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


// All the different kinds of (R)ead functions we need to present the blog:

function getContent($id,$field)
{

$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


$query = "
    SELECT
        $field
    FROM
        jamieContent
    WHERE
        id = $id
    ";
$rows=mysqli_query($mysqli,$query);
$result=mysqli_num_rows($rows);

if ($result)
{
    while ($row = mysqli_fetch_array($rows,MYSQLI_NUM))
    {
        $content = $row[0];
    }

    // typical action
    return $content;
}

}

// function generateAbout()
// {

// $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// $query = "
//     SELECT
//         id
//     FROM
//         jamieContent
//     WHERE
//         type = 'About'
//     ";

// $rows=mysqli_query($mysqli,$query);
// $result=mysqli_num_rows($rows);

// if ($result)
// {
//     while ($row = mysqli_fetch_array($rows,MYSQLI_NUM))
//     {
//         $title = getContent($row[0],"title");
//         $text = getContent($row[0],"text");
//         $entry .= "<div class=headline>$title</div><div class=bioText href=$text target=_blank>$text</div>";
//     }
//     // typical action
//     return $entry;
// }

// }

// $blogAbout = generateAbout();


// for the header
$header="Ratio Architectus";

//for the footer
$footer="&copy; 2016 Pete Wright";
?>

<!DOCTYPE html>
<html lang="en">
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Ratio Architectus • Home</title>
        <link rel="stylesheet" href="_css/styles.css" type="text/css">
        <script src="https://use.typekit.net/pha1ivh.js"></script>
        <script>try{Typekit.load({ async: true });}catch(e){}</script>
            
    </head>
    <body>

    <div id="container">

        <header>
            <div id="masthead">
            
                <a href="index.html">
                    <p class="title">Ratio Architectus</p>
                    <!-- <img src="_images/masthead-new6.png" height="73" width="280"> -->
                </a>
            </div>
            <div id="shadow"></div>
        </header>

            <nav>
                <a href="index.html" class="chosen">HOME</a>
                <a href="about.html">ABOUT</a>
                <a href="links.html">LINKS</a>
                <!-- <a href="contact.html">CONTACT</a> -->
            </nav>


            <div id="sidebar">
                <p class="sidehed">
                RECENT POSTS
                </p>
                <p class="sidetext"> <a href="#">
                Installing OpenSMTPD On FreeBSD</a>
                </p>
                <p class="sidetext"> <a href="#">
                Configinit on AWS</a>
                </p>
            

                <div id="social">
                    <a class="icon-mail"><href="mailto:nomadlogic@gmail.com"></a>
                    <a class="icon-twitter2"><href="http://www.twitter.com" target="_blank"></a>
                    <a class="icon-linkedin"><href="http://www.linkedin.com" target="_blank"></a>
                </div>


            </div>


            <div id="sidebarMobile">
                <p class="sidehed">
                RECENT POSTS
                </p>
                <p class="sidetext"> <a href="#">
                Installing OpenSMTPD On FreeBSD</a>
                </p>
                <p class="sidetext"> <a href="#">
                Configinit on AWS</a>
                </p>
                

                <div id="socialMobile">
                    <a class="icon-mail"><href="mailto:nomadlogic@gmail.com"></a>
                    <a class="icon-twitter2"><href="http://www.twitter.com" target="_blank"></a>
                    <a class="icon-linkedin"><href="http://www.linkedin.com" target="_blank"></a>
                </div>


            </div>

            <div id="main">

            <article>
                <h1>Installing OpenSMTPD On FreeBSD</h1>
                        <p class="datetext"> Jun 9, 2016 </p>
                        <p class="maintext">
                        This blog post is hopefully a usefull set of breadcrumbs for configuring your own OpenSMTPD based mail server on FreeBSD.  My configuration is prety standard, so maybe it'll be useful for others who host their own email.  The basic configuration will consist of the following components:
                        </p>

                        <pre>   
FreeBSD 10.3-RELEASE
OpenSMTPD v5.7.3p2
OpenSMTPD-extras
Dovecot IMAP
                        </pre>

                        <p>
                        For this exercise we will install all software via the FreeBSD <a href="https://www.freebsd.org/cgi/man.cgi?query=pkg&apropos=0&sektion=7&manpath=FreeBSD+10.3-RELEASE+and+Ports&arch=default&format=html">pkg(7)</a> utility.  As mentioned earlier my requirements are pretty simple.  I have a couple local users who I trust who have accounts on my system.  I want to provide IMAP access for mail storage, and I want to allow them to send email via my system as well.  My previous configuration was based on Dovecot and Postfix, which works great.  Although since I am shuffling my personal servers around I'm taking the opportunity to test out OpenSMTPD as my primary MTA.
                        </p>
                                               
                        <p class="maintext_indent">
                                                First lets get the easy bits out of the way - let's install the OpenSMTPD packages.  I am going to assume you know how to install and perform basic systems administration tasks on FreeBSD.  If you don't and would like to give FreeBSD a spin check out my ISP <a href="https://arpnetworks.com/vps" target="blank">ARP Networks</a>.  They have FreeBSD VPS servers reasonably priced.  So, let's first install OpenSMTPD and the OpenSMTPD-extras package via the pkg(7) utility:
                        </p>

                        <pre>

% sudo pkg install opensmtpd opensmtpd-extras
Updating FreeBSD repository catalogue...
FreeBSD repository is up-to-date.
All repositories are up-to-date.
The following 13 package(s) will be affected (of 0 checked):

New packages to be INSTALLED:
        opensmtpd: 5.7.3_2,1
        opensmtpd-extras: 201602042118
        libevent2: 2.0.22_1
        libasr: 1.0.2
        python27: 2.7.11_2
        libffi: 3.2.1
        openssl: 1.0.2_12
        mysql56-client: 5.6.30
        libedit: 3.1.20150325_2
        sqlite3: 3.11.1
        postgresql93-client: 9.3.12
        perl5: 5.20.3_12
        hiredis: 0.13.3

The process will require 187 MiB more space.
31 MiB to be downloaded.

Proceed with this action? [y/N]: y
                      </pre>

                        <p class="maintext_indent">
                                                Wow, the openstmpd-extras package pulls in a lot of extra dependencies.  I struggled for a while contemplating rebuilding this package to not include the MySQL and PostgreSQL client packages as I don't have a use-case for RDBMS backends.  I eventually decided that the overhead of managing a custom repository was not worth the bloat of having client libraries for these systems on my mail server.  I am also hoping the FreeBSD packaging team will do a better job than me at tracking security vulns on this software than Iw ould be able to do.
                        </p>
                                                
                                                <p class="maintext_indent">
                                                Next I needed to manually create some directories and adjust their permissions for OpenSMTPD like so.  In theory this is done by the package at install time, but this was not the case for me.
                                                </p>
                                                <pre>

% mkdir -p /var/spool/smtpd/{corrupt,incoming,purge,queue,temporary}
% sudo chmod 0711 /var/spool/smtpd/
% sudo chmod 0700 /var/spool/smtpd/*
% sudo chown _smtpq /var/spool/smtpd/*
                                                </pre>


                        <p class="maintext_indent">
                        Once I created the appropriate directory structure for OpenSMTPD's mail spool I went ahead and configured /etc/rc.conf to completely disable sendmail(8) and enable OpenSMTPD:
                        </p>
                                                <pre>

# Mailer Config
# first completely disable sendmail
sendmail_enable="NO"
sendmail_submit_enable="NO"
sendmail_outbound_enable="NO"
sendmail_msp_queue_enable="NO"
# enable opensmtpd
smtpd_enable="YES"
                                                </pre>
                                                <p class="maintext_indent">
                                                At this point I was then able to configure OpenSMTPD, using the manpage for smtpd.conf(5) as reference.  Read the man page, this is just for illustrative purposes!  For example, the man documents how to generate selfsigned SSL keys which I will not cover here.  Here is my config file with some helpful documentation. 
                                                </p>
                                                <pre>

% cat /usr/local/etc/mail/smtpd.conf
# This is the smtpd server system-wide configuration file.
# See smtpd.conf(5) for more information.

# Macros
pub_int = "vtnet0"

# PKI config
pki mail.nomadlogic.org certificate "/usr/local/etc/mail/
ssl/mail.mydomain.org.crt"
pki mail.nomadlogic.org key "/usr/local/etc/mail/ssl/mail.
mydomain.org.key"

# Listen Rules, loopback no auth but encrypt/auth on public
listen on lo0
listen on $pub_int tls pki mail.mydomain.org auth

# If you edit the file, you have to run "smtpctl update 
table aliases"
table aliases file:/etc/mail/aliases

# accept local messages and deliver to users maildir
accept from any for domain "mydomain.org" alias <aliases> deliver to maildir

# allow outgoing emails
accept for any relay
                                                </pre>
                                                <p class="maintext_indent">
                                                So now I have configured SMTP daemon and I am able to start smtpd and verify in the logs that everything is in place.  Next steps are configuring Dovecot and doing actual testing.  Stay tuned to future posts on that phase.
                                                </p>
                    <div class="rule"></div>
            </article>

            

        <!-- STYLE GUIDE -->

            <!-- LINKS -->
                <!-- <a href="url_here" target="blank"> -->

            <!-- BULLET LISTS -->   

                        <!-- <ul>
                             <li> velit esse cillum dolore eu fugiat</li>
                             <li> nulla pariatur. Excepteur sint occaecat cupidatat</li>
                             <li> non proident, sunt in culpa qui officia</li>
                         </ul> -->


            <!-- SAMPLE POST -->


            <!-- <article>
                <h1>Another Blog Post Title Here</h1>
                    
                    <p class="datetext"> January 28, 2016 
                    </p>
                        <img src="_images/IMG_20150912_063147.jpg">
                    <p class="caption"> Caption here Caption here Caption here Caption here Caption here Caption here Caption here Caption here Caption here Caption here Caption here Caption here Caption here.
                    </p>
                    <p class="maintext">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate 
                    </p>

                         <ul>
                             <li> velit esse cillum dolore eu fugiat</li>
                             <li> nulla pariatur. Excepteur sint occaecat cupidatat</li>
                             <li> non proident, sunt in culpa qui officia</li>
                         </ul>

                    <p class="maintext">deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia </p>
                <div class="rule"></div>
                    
            </article> -->

            <!-- STYLE GUIDE END -->

<article>
<h1>Configinit on AWS</h1>

<p class="datetext"> October 15, 2016 
                    </p>
                        <img src="_images/IMG_20150912_063147.jpg">
                        <p class="caption">The Cloud!
                    </p>
<p class="maintext">
Traditionally cloud service providers, like Amazon Web Services (AWS) or Google Compute Engine (GCE), have focused mostly on running Linux distributions in their environments.  Fortunately for me there are developers out there with the technical skills to support non-Linux systems such as FreeBSD and NetBSD on AWS.  Specifically I am refering to the work done by Colin Percival (http://www.daemonology.net/freebsd-on-ec2/) on FreeBSD, which I have taken advantage of as soon as he publically released AMI images for testing.  And while it is awesome to have FreeBSD running in AWS there is one feature worth highlighting which I feel is a nice differentiator between the FreeBSD approach to systems automation and configuration and what you may find on Linux systems.  I am speaking of configinit: http://www.daemonology.net/blog/2013-12-09-FreeBSD-EC2-configinit.html
</p>

<p class="maintext_indent">
This blog post will cover leveraging configinit on FreeBSD to easily install arbitrary packages, and configure SaltStack (a popular configuration management engine).  Hopefully this demonstration will illustrate that a simple, clearly defined tool is capable of managing a wide array of tasks.  This is also known as “the Unix way” for those following along at home.
</p>

<p class="maintext_indent">
The tl;dr spiel for configinit is that it is akin to CloudInit (as you would find on CentOS or Ubuntu), uses the same AWS EC2 services yet is IMHO easier to configure.  By coupling this with the classic BSD rc init system I am able to configure a SaltStack client in several lines of code.
</p>

<p class="maintext_indent">
For starters here is our example configinit script:
</p>

<pre>

{
#!/bin/sh
sed -i .dist 's/awscli/awscli\ py27-salt\ bash\ tmux\ sudo\ 
vim-lite/g'  /etc/rc.conf
echo "hostname="$HOSTNAME.iad.tribdev.com"" >> /etc/rc.conf

mkdir -p /usr/local/etc/salt/

echo "master: 10.0.0.52" >> /usr/local/etc/salt/minion
echo "hash_type: sha512" >> /usr/local/etc/salt/minion

echo "salt_minion_enable="YES"" >> /etc/rc.conf

}

</pre>
<p class="maintext_indent">
This example is a simple /bin/sh script that simply appends a list of packages to be installed on first boot, then drops in a base SaltStack minion config and finally enables the salt_minion service.


<p class="maintext_indent">
I should note one other feature of the FreeBSD EC2 images, as I’ll illustrate below, when you first boot a FreeBSD EC2 instance it will perform a freebsd-update (another utility written by Colin) to ensure your new system is fully patched against the RELEASE branch you are deploying.  This saves some work as an admin, as I don’t have to configure my CloudInit script to perform an upgrade myself.  Having sane default behaviour is an added bonus in such a hostile environment like AWS.
</p>

<p class="maintext_indent">
So let’s show this in action shall we?
</p>

<pre>

{insert GUI example of deploying configinit script in AWS console}

</pre>

<p class="maintext_indent">
Here we are provisioning a FreeBSD-10.3-RELEASE EC2 instance, and in the instance details page we paste in our example configinit snippet.  This would be the identical method for deploying your CloudInit script.
</p>


<pre>

{
-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\/boot/kernel/kernel text=0xfe2da8 |/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|/-\|data=0x129430+0x207f90 /-\|/-\|/syms=[0x8+0x146f40-\|/-\|/-\+0x8+0x16136c|/-\|/-\|/-]


Booting [/boot/kernel/kernel]...               
\|/-\Copyright (c) 1992-2016 The FreeBSD Project.
Copyright (c) 1979, 1980, 1983, 1986, 1988, 1989, 1991, 1992, 1993, 1994
    The Regents of the University of California. All rights reserved.
FreeBSD is a registered trademark of The FreeBSD Foundation.
FreeBSD 10.3-RELEASE #0 r297264: Fri Mar 25 02:10:02 UTC 2016
    root@releng1.nyi.freebsd.org:/usr/obj/usr/src/sys/GENERIC amd64
FreeBSD clang version 3.4.1 (tags/RELEASE_34/dot1-final 208032) 20140512
XEN: Hypervisor version 4.2 detected.
CPU: Intel(R) Xeon(R) CPU E5-2676 v3 @ 2.40GHz (2400.05-MHz K8-class CPU)
  Origin="GenuineIntel"  Id=0x306f2  Family=0x6  Model=0x3f  Stepping=2
  Features=0x1783fbff<FPU,VME,DE,PSE,TSC,MSR,PAE,MCE,CX8,APIC,SEP,MTRR,PGE,MCA,CMOV,PAT,PSE36,MMX,FXSR,SSE,SSE2,HTT>
  Features2=0xfffa3203<SSE3,PCLMULQDQ,SSSE3,FMA,CX16,PCID,SSE4.1,SSE4.2,x2APIC,MOVBE,POPCNT,TSCDLT,AESNI,XSAVE,OSXSAVE,AVX,F16C,RDRAND,HV>
  AMD Features=0x28100800<SYSCALL,NX,RDTSCP,LM>
  AMD Features2=0x21<LAHF,ABM>
  Structured Extended Features=0x728<BMI1,AVX2,BMI2,ERMS,INVPCID>
  XSAVE Features=0x1<XSAVEOPT>
<snip dmesg info>
Starting dhclient.
DHCPDISCOVER on xn0 to 255.255.255.255 port 67 interval 6
DHCPOFFER from 10.0.4.1
DHCPREQUEST on xn0 to 255.255.255.255 port 67
DHCPACK from 10.0.4.1
bound to 10.0.4.251 -- renewal in 1800 seconds.
Starting Network: lo0 xn0.
lo0: flags=8049<UP,LOOPBACK,RUNNING,MULTICAST> metric 0 mtu 16384
    options=600003<RXCSUM,TXCSUM,RXCSUM_IPV6,TXCSUM_IPV6>
    inet6 ::1 prefixlen 128 
    inet6 fe80::1%lo0 prefixlen 64 scopeid 0x1 
    inet 127.0.0.1 netmask 0xff000000 
    nd6 options=21<PERFORMNUD,AUTO_LINKLOCAL>
xn0: flags=8843<UP,BROADCAST,RUNNING,SIMPLEX,MULTICAST> metric 0 mtu 1500
    options=503<RXCSUM,TXCSUM,TSO4,LRO>
    ether 0a:77:ca:2a:ca:c5
    inet 10.0.4.251 netmask 0xffffff00 broadcast 10.0.4.255 
    nd6 options=29<PERFORMNUD,IFDISABLED,AUTO_LINKLOCAL>
    media: Ethernet manual
    status: active
Starting devd.
add net fe80::: gateway ::1
add net ff02::: gateway ::1
add net ::ffff:0.0.0.0: gateway ::1
add net ::0.0.0.0: gateway ::1
Generating host.conf.
Fetching EC2 user-data.
Processing EC2 user-data.
Installing pkg-1.8.7_3...
Extracting pkg-1.8.7_3: .......... done
Bootstrapping pkg from pkg+http://pkg.FreeBSD.org/FreeBSD:10:amd64/quarterly, please wait...
Verifying signature with trusted certificate pkg.freebsd.org.2013102301... done
Updating FreeBSD repository catalogue...
Fetching meta.txz: . done
Fetching packagesite.txz: .......... done
Processing entries: .......... done
FreeBSD repository update completed. 25472 packages processed.
Updating database digests format: . done
The following 45 package(s) will be affected (of 0 checked):

New packages to be INSTALLED:
    awscli: 1.10.63
    py27-salt: 2016.3.3
    bash: 4.4
    tmux: 2.3
    sudo: 1.8.18
    vim-lite: 8.0.0019_1
    py27-rsa: 3.3
    py27-pyasn1: 0.1.9
    python27: 2.7.12
    libffi: 3.2.1
    indexinfo: 0.2.5
    gettext-runtime: 0.19.8.1
    py27-setuptools27: 23.1.0
    python2: 2_3
    py27-colorama: 0.3.3
    py27-docutils: 0.12
    py27-botocore: 1.4.53
    py27-jmespath: 0.9.0
    py27-dateutil: 2.5.3
    py27-six: 1.10.0
    py27-s3transfer: 0.1.4
    py27-futures: 3.0.5
    py27-requests: 2.11.1
    py27-enum34: 1.1.6
    py27-yaml: 3.11_1
    py27-progressbar: 2.3_2
    py27-pycrypto: 2.6.1_1
    gmp: 5.1.3_3
    py27-Jinja2: 2.8
    py27-Babel: 2.3.4
    py27-pytz: 2016.6.1,1
    py27-MarkupSafe: 0.23
    py27-msgpack-python: 0.4.7
    py27-libcloud: 1.2.1
    py27-tornado: 4.4.2
    py27-singledispatch: 3.4.0.3
    py27-certifi: 2016.2.28
    py27-backports_abc: 0.4
    py27-pyzmq: 15.4.0
    libzmq4: 4.1.5
    openpgm: 5.2.122_2
    perl5: 5.20.3_15
    norm: 1.5r6
    libsodium: 1.0.11
    libevent2: 2.0.22_1

Number of packages to be installed: 45
<snip pkg install messages>
freebsd-update: src component not installed, skipped
freebsd-update: Looking up update.FreeBSD.org mirrors... 4 mirrors found.
freebsd-update: Fetching public key from update6.freebsd.org... done.
freebsd-update: Fetching metadata signature for 10.3-RELEASE from update6.freebsd.org... done.
freebsd-update: Fetching metadata index... done.
freebsd-update: Fetching 2 metadata files... done.
freebsd-update: Inspecting system... done.
freebsd-update: Preparing to download files... done.
freebsd-update: Fetching 91 patches.....10....20....30....40....50....60....70....80....90 done.
freebsd-update: Applying patches... done.
freebsd-update: 
freebsd-update: The following files will be updated as part of updating to 10.3-RELEASE-p9:
freebsd-update: /bin/freebsd-version
<snip lots of update info>

freebsd-update: Installing updates... done.
freebsd-update: Requesting reboot after installing updates.
<snip>

Waiting (max 60 seconds) for system process `vnlru' to stop...done
Waiting (max 60 seconds) for system process `bufdaemon' to stop...done
Waiting (max 60 seconds) for system process `syncer' to stop...
Syncing disks, vnodes remaining...377 307 281 164 137 100 0 0 done
All buffers synced.
Uptime: 2m13s
Rebooting...
cpu_reset: Stopping other CPUs

}

</pre>

<p class="maintext_indent">
And as I mentioned earlier, here is freebsd-update running on first boot ensuring that whatever horrible bugs in OpenSSL have cropped up since this image was created is sorted out.
</p>

<pre>
{insert output of pkg’s being installed}
</pre>

<p class="maintext_indent">
Here we see that configinit is installing the additional packages we wanted.  You’ll note that previously all we were doing was appending additional packages to the firstboot_packages list - another nice feature of FreeBSD.
</p>

<pre>
{insert output of salt configured}
</pre>

<p class="maintext_indent">
Here we can see my salt minion.conf file is deployed.  The system will reboot at this point, and when it comes back online we’ll be off to the races.  While you wait for the reboot to complete, maybe authorize the new minion on your Salt master.
</p>

            <!-- <div> <img class="jump" src="_images/arrow_jump.svg" height="175" width="175"></div> -->

            

            <!-- <div id="sidebar">
                <p class="sidehed">
                RECENT POSTS
                </p>
                <p class="sidetext"> <a href="#">
                Installing OpenSMTPD On FreeBSD</a>
                </p>
                <p class="sidetext"> <a href="#">
                Configinit on AWS</a>
                </p>
                <p class="sidetext"> <a href="#">
                Post title here tk tk post</a>
                </p>
                <p class="sidetext"> <a href="#">
                Post title here tk tk post</a>
                </p>
                <p class="sidetext"> <a href="#">
                Post title here tk tk post</a>
                </p>

                <div id="social">
                    <a class="icon-mail"><href="mailto:nomadlogic@gmail.com"></a>
                    <a class="icon-twitter2"><href="http://www.twitter.com" target="_blank"></a>
                    <a class="icon-linkedin"><href="http://www.linkedin.com" target="_blank"></a>
                </div>


            </div> -->
            

        <!--    <div id="button1"><a href="#">Next</a></div>
            <div id="button2"><a href="#">Previous</a></div>
 -->


 </article>
</div>
 
                <div id="space"></div>

            <footer>
                &copy; 2016 Pete Wright 
            </footer>
        </div>

            <script type="text/javascript" src="_js/jquery-3.0.0.min.js"></script>
            <script type="text/javascript" src="_js/scripts.js"></script>



    </body>
</html>