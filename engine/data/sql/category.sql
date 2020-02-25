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
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `parent_id`, `name`, `slug`, `icon`, `description`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Auto & Moto', 'auto-moto', 'fa-car', 'sample description', 1, 'active', '2017-02-26 21:18:24', '2017-06-14 16:58:15'),
(2, 1, 'Automobiles', 'automobiles', 'fa-car', 'sample description', 1, 'active', '2017-02-26 21:18:24', '2018-03-16 07:53:27'),
(3, 1, 'Trucks', 'trucks', 'fa-car', 'sample description', 2, 'active', '2017-02-26 21:18:24', '2017-06-14 16:58:58'),
(4, 1, 'Motorcycles, Scooters, ATVs', 'motor', 'fa-car', 'sample description', 3, 'active', '2017-02-26 21:18:24', '2017-06-14 16:59:13'),
(5, 1, 'Auto parts', 'auto-parts', 'fa-car', 'sample description', 4,'active', '2017-02-26 21:18:24', '2017-06-14 17:01:12'),
(6, 1, 'Boats, Yachts', 'boats', 'fa-car', 'sample description', 5,'active', '2017-02-26 21:18:24', '2017-02-26 21:18:24'),
(7, NULL, 'Real Estate', 'real-estate', 'fa-home', 'sample description', 2,'active', '2017-02-26 21:18:24', '2017-06-14 20:33:45'),
(8, 7, 'Apartments', 'apart', 'fa-home', 'sample description', 1,'active', '2017-02-26 21:18:24', '2017-06-14 20:34:00'),
(9, 7, 'Houses', 'houses', 'fa-home', 'sample description', 2,'active', '2017-02-26 21:18:24', '2017-06-14 20:34:36'),
(10, 7, 'Offices', 'offices', 'fa-home', 'sample description', 3,'active', '2017-02-26 21:18:24', '2017-02-26 21:18:24'),
(11, 7, 'Others', 'others', 'fa-home', 'sample description', 4,'active', '2017-02-26 21:18:24', '2017-02-26 21:18:24'),
(12, NULL, 'Fashion', 'fashion', 'fa-diamond', 'sample description', 3,'active', '2017-02-26 21:18:24', '2017-06-14 20:25:47'),
(13, NULL, 'Electronics & appliances', 'electronics', 'fa-headphones', 'sample description', 4,'active', '2017-02-26 21:18:24', '2017-06-14 20:27:51'),
(14, 13, 'Computers & Laptops', 'computer', 'fa-headphones', 'sample description', 1,'active', '2017-02-26 21:18:24', '2017-06-14 20:28:09'),
(15, 13, 'Home Appliances', 'home-applience', 'fa-headphones', 'sample description', 2,'active', '2017-02-26 21:18:24', '2017-06-14 20:28:21'),
(16, 13, 'Mobile and Tablet', 'mobile', 'fa-headphones', 'sample description', 3,'active', '2017-02-26 21:18:24', '2017-06-14 20:28:33'),
(17, 13, 'TV and Media', 'tv', 'fa-headphones', 'sample description', 4,'active', '2017-02-26 21:18:24', '2017-06-14 20:28:49'),
(18, NULL, 'Pets', 'pets', 'fa-paw', 'sample description', 5,'active', '2017-02-26 21:18:24', '2017-02-26 21:18:24'),
(19, 18, 'Dogs', 'dogs', 'fa-paw', 'sample description', 1,'active', '2017-02-26 21:18:24', '2017-02-26 21:18:24'),
(20, 18, 'Cats', 'cats', 'fa-paw', 'sample description', 2,'active', '2017-02-26 21:18:24', '2017-02-26 21:18:24'),
(21, 18, 'Birds', 'birds', 'fa-paw', 'sample description', 3,'active', '2017-02-26 21:18:24', '2017-02-26 21:18:24'),
(22, 18, 'Others', 'others-2', 'fa-paw', 'sample description', 4,'active', '2017-02-26 21:18:24', '2017-02-26 21:18:24'),
(23, NULL, 'Jobs', 'jobs', 'fa-suitcase', 'sample description', 6,'active', '2017-02-26 21:18:24', '2017-06-14 20:30:39'),
(24, 23, 'Full time', 'fulltime', 'fa-suitcase', 'sample description', 1,'active', '2017-02-26 21:18:24', '2017-06-14 20:31:07'),
(25, 23, 'Part time', 'parttime', 'fa-suitcase', 'sample description', 2,'active', '2017-02-26 21:18:24', '2017-06-14 20:31:18'),
(26, 23, 'Freelance', 'freelance', 'fa-suitcase', 'sample description', 3,'active', '2017-02-26 21:18:24', '2017-06-14 20:31:33'),
(27, 23, 'Project Based', 'project', 'fa-suitcase', 'sample description', 4,'active', '2017-02-26 21:18:24', '2017-06-14 20:31:48'),
(28, NULL, 'Home and garden', 'garden', 'fa-pagelines', 'sample description', 7,'active', '2017-02-26 21:18:24', '2017-02-26 21:18:24'),
(29, 28, 'Home stuff', 'stuff', 'fa-pagelines', 'sample description', 1,'active', '2017-02-26 21:18:24', '2017-02-26 21:18:24'),
(30, 28, 'Garden stuff', 'garden-stuff', 'fa-pagelines', 'sample description', 2,'active', '2017-02-26 21:18:24', '2017-02-26 21:18:24'),
(31, 28, 'Tools', 'tools', 'fa-pagelines', 'sample description', 3,'active', '2017-02-26 21:18:24', '2017-02-26 21:18:24'),
(32, 28, 'Electric machines', 'electric-machines', 'fa-pagelines', 'sample description', 4,'active', '2017-02-26 21:18:24', '2017-02-26 21:18:24');