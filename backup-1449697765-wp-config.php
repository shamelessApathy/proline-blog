<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'islandi7_wordpressba7');

/** MySQL database username */
define('DB_USER', 'islandi7_wordba7');

/** MySQL database password */
define('DB_PASSWORD', '6hcaghS0RTlf');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'n_NX*v-?qy=N;d+rgjzGAcFw$Nwc<*NF{wza%(SV&-Q]Mz*!J})b(y)LSXX;dM&Vo&xS[Y&hBw}V<XdFb<rFyGq|)i}q>z@jc^/%rZ/QH%BUxSUyPi<{dZV/tN/xc_km');
define('SECURE_AUTH_KEY', ';bkBj%wur*oXGB_pTRBSz{P_(xXFd%tGHLmv|VPOz>kpgy?IAd!QHadS[y%_l=g^A+n/Ur|RAW|MD;UgVwS&uTh%?[BU+lTmy;xR[AkPtkqVS{a$u<Jmm_;$nX+&ZCyY');
define('LOGGED_IN_KEY', '$ki;dPYG[RcG=Uu)hexXlYEZY|P{=GXOQD]JxT=LK[BgCS!dK*{Iq>UcC>+KS>MAd_fwXJFuq]hT%goKAf%;-MZ+/RsDrT<jOe)Ps!]{C/Ery*&GygCd=pPKMnoZTkSM');
define('NONCE_KEY', '[/;tUCR;|-Vi[(FmMHTn}fW*wEoY_QbTSpBx^=ij]I$myg^iQ$j_mpHj*}T}_kPoOF*nfX(%psVgT=+pbe@thtLEd>({vdcbAkS^>d;GJkn<i|(b-N/Iq/tP^G!{J;?_');
define('AUTH_SALT', 'f[|!__IwO(Stsbd&X<Cwp?s]<NM(I-cETpx-zj*(<X[=!LW;w*$Z/A?]ejOaJGs_++sr$ljoSYr{OjOIKj$la@E<qLO>yeme|@B/_-{bsoZ)wksbK?ti)n=HVVC-wsr@');
define('SECURE_AUTH_SALT', 'UkztlmCHUgbGty%V]^Xij%af}zd{oTd_H*N]GYCIVeLD{<$cw]K|udVdKj}@IjOo!^dsB}_JI+)aRWrfMLu[x;tVN(/*WSxYJxXKtH^ET_bA<>AcPRwErFbdXgGH*Q!t');
define('LOGGED_IN_SALT', '|<O{u}*AtLQyQ!|aOSZjm%Dtm)-<X?+c;rV!YJVJ%WnNnYjW)_d=h}S>?KmUNSsiFu<HJLSReSbGy}rgl^p@|UHd-HLEYX>wvB<JN?+RaWO*u;{WtcF}FVQl!X/pVoCa');
define('NONCE_SALT', ';n{KeFa[aXeBr-gxTxP/e*{L%QZc}!+dTPF*SCUxmpaFNh;B!jbsJH!b_A>UrOPxQrmL!&Spa&nGTvdWCFm;pycJmgr(H%yO@{|oJ{UwDX|q@KUMkcxZ=T/Q^T@f!%OW');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_cbpz_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');