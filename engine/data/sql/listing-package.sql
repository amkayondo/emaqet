/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.6
 */


--
-- Dumping data for table `listing_package`
--

INSERT INTO `listing_package` (`package_id`, `title`, `price`, `listing_days`, `promo_days`, `promo_show_featured_area`, `promo_show_at_top`, `promo_sign`, `recommended_sign`, `auto_renewal`, `created_at`, `updated_at`) VALUES
(1, 'Free', 0, 30, 0, 'no', 'no', 'no', 'no', 0, '2017-06-14 16:25:24', '2017-06-14 16:25:24'),
(2, 'Promo', 10, 30, 10, 'yes', 'yes', 'yes', 'yes', 2, '2017-06-14 17:06:44', '2017-06-14 17:06:44'),
(3, 'Promo Plus', 25, 60, 30, 'yes', 'yes', 'yes', 'no', 4, '2017-06-15 00:12:27', '2017-06-15 08:41:32');