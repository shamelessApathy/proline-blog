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
define('DB_NAME', 'islandi7_wordpress2f9');

/** MySQL database username */
define('DB_USER', 'islandi7_word2f9');

/** MySQL database password */
define('DB_PASSWORD', '1luhv1j5YT5S');

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
define('AUTH_KEY', 'uUew*JNe>}hXyxoq;XlzSu}OZEfiPQL|t/a$dr-/FiwO}DNu*|?ag(u-aI+)}vDMPQ?Js=R%QN^_b=GtRP{&=GujJucdheT}KP;cLZRT<R-g$tJTUfqPhWbFKqna)-gf');
define('SECURE_AUTH_KEY', 'ETy(uTzI@L};Crj<-FZG!}rGy>HoW;(bLbFPIBG*emFIWh=;Zhc^|BicFTV<|c=eAX+hkV$EsBS{ucSnklR@}ET<C{;@{_F$q?i&!<mRHNRmvi||BL(pusbO!iLS!*rU');
define('LOGGED_IN_KEY', ';Crsdx/juNxJfi}>J>=jG=AYr;nr^_LSBnWBkHWno/zzENbLMtms=t<d@}Am+^zu>STtw&?L!O&HSYQKnj|=Ib@FSqruM$BTrK^WZw}MwfA{>W(wQzc!EYd]<hRHgfee');
define('NONCE_KEY', 'KBe>mBs!yA/SX|dShAd<ft<W><q)E(w)sUcOv[h)GR[_S|q<QNKqruQBo{Lybecc@tB@DldsIFMW?d@D!CgtIEhIck]=|hoa+ibqN^g{ACuU}V!()gJ-z]Ayon$s$nZS');
define('AUTH_SALT', 'npTD>]Nq=I-cw;M!JSuy_e?f{m)PN)j%U|jRiNA%@Bzo;&/XEc|gjNl;oozr*qP&GCjIbA^t^p+fDl*L+s;y^/jyK()%i[bjLgYIBE^Ow%jGBPrOXA[>dr=HbIp]z^SZ');
define('SECURE_AUTH_SALT', 'I>u}albTngCp{zAA+f}ijt_d!?R!]_jPhIufz-!B)VKMI;w_)ReCE<{?g}kbzi@q|lT@GglK-p_-grwy!?}ImS;%&J!GvefqMVRXsymxEs}^Rdf)H?ty>YI>eOe{d{ry');
define('LOGGED_IN_SALT', 'U%>$qO&T}wU)a!PfChI{z|RsBb@ttNyAe*EKda}dN|>COZRyMSC<JeDwQA<**^SNRC{+X@BfMv)OxVY_-*@-mGec%rIQfxt$!uYEYwYOblO?nqLDrkUQlpFG=pu{$iG-');
define('NONCE_SALT', 'o)bl&@ocPMy-$idePcN&[VNNHfI^ven]G[F@d{V%}St^*Is<y@+XFGSCL|Sg$F>jXykGv*Z<Rg*QjgCVjzXrhT[ZIT%_g-invP[HM-JPjfCWyy|c=hvvxRExGFiR-u_}');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_eckx_';

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