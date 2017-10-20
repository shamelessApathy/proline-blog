<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


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
define('DB_NAME', 'proliner_kitchenblog');

/** MySQL database username */
define('DB_USER', 'prolinerangehood');

/** MySQL database password */
define('DB_PASSWORD', 'Ouiqnl2016#');

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
define('AUTH_KEY', 'l$;[+$GBE$HQKNBv^R=SP_YkwcH@FKU/{d=SS*iS{@hyXy(T>yu$^?l+QSEi_Q[XnCBPO_p;KO;OvRQ_K&/bKaBdcrfK[q/eJo*)<yg%%*)K;Wv>}^CUMKT[[-ok*q/i');
define('SECURE_AUTH_KEY', '=|<V/k)rjU@]d{iLv(?fjpu{T-)tL)wIZ!Jyl/amhZ{LtsDUjQUpLq%BNtb}Bfkx^E-]]}]xwFT@Mw%?i+$CtN]hwIRChi[(RzMTkt&csN_WnaZ/eyh-|*W>ZMRh]+eS');
define('LOGGED_IN_KEY', 'JJk;vmL[v*FS{_zl?(/ctP{%CkmM;&}=uknWq)[S_K-JSUaAY&oOI[%$PZyIgIrfRSyPTNMcsxEUK]xY%OC*kWtEh]SJv/k^x$PKPSon*L[LQyHmOVni(@p<oFO?Pn$G');
define('NONCE_KEY', 'mikfzWh>n$zSQMr{)yUw|%eFLz_v@?F!?kq-jcbYlA|]OgDIT<I_FEarFPncWCV^>B{a/JRBIHXTzmoXvm)zG&fPa/y@HK@d$kfRtbHEh}DtSlUT-@mX|vp[O*_%MrZ!');
define('AUTH_SALT', '_/DnAH[}pTFF_tvJ)%U*IhIkZzT*pctqjT(R;vtkGn^>o*tmn+glYrdtX/r<+)BHvl{W(qI]<)Z&%uv_|XFs<VwI)rhECDui&XS/l?l|jkObi++wUSC%g]e=Nt}]<mmk');
define('SECURE_AUTH_SALT', 'YmpK_^eym/CK[Jh{s%nI+=LG]OSKSaU{yQARrzTuqfpEjPB>FgBIiFVVil=mth@fFGVinzb@;G>icON/Px-xlmj-[W(sTaekMZJqts{e^=/<$Wt<FV()>xOkR]j{F=tM');
define('LOGGED_IN_SALT', 'UKXcgN%OymB=(xb[SefvSrrOOgmdEbMGBoonQ[x^L/ywZ|N(lg;YWJ]L(<G;QmdXL=*cdF)SmZ=JN@GWaw!mvDg>mAv[re!iI{azS;HNklhL+>UAPZF{k?xuQLLeMr*q');
define('NONCE_SALT', 'HjByrZIbg)@/EcR&;}M(fPd*Y-qlf>tUDw=BG^fazmmWEPQZURWeoLePJzWnu^XMdLoeGLYu+unc{|}+gM(u&hwf${gLU%eDlFCPgM!u^uyo@z+ERrj/@kqKZCqquJDp');

/**#@-*/
// Adding memory limit declaration
define('WP_MEMORY_LIMIT', '128M');
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_oocu_';

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
