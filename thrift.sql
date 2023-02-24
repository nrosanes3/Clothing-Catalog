-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 17, 2021 at 04:53 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nrosanes3`
--

-- --------------------------------------------------------

--
-- Table structure for table `thrift`
--

CREATE TABLE `thrift` (
  `item_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `item_name` varchar(80) NOT NULL,
  `color` varchar(80) NOT NULL,
  `size` varchar(3) NOT NULL,
  `item_condition` varchar(80) NOT NULL,
  `category` varchar(80) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `item_description` text NOT NULL,
  `brand` varchar(100) NOT NULL,
  `image_name` varchar(100) NOT NULL,
  `deleted_yn` char(1) NOT NULL DEFAULT 'N',
  `item_sold_yn` char(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thrift`
--

INSERT INTO `thrift` (`item_id`, `u_id`, `item_name`, `color`, `size`, `item_condition`, `category`, `price`, `item_description`, `brand`, `image_name`, `deleted_yn`, `item_sold_yn`) VALUES
(11, 2, 'Floral Mustard Shirt', 'Yellow', 'XXS', 'Like new', 'Tops', '20', 'Feminine flair abounds in this delicate satin shirt. It features cuffed sleeves, a v-neck, and a collar.', 'Dynamite', 'yellow-shirt.jpg', 'N', 'N'),
(12, 2, 'Plaid Blazer', 'Brown', 'S', 'Good', 'Coats', '35', 'Buttoned brown plaid blazer with two pockets.', 'Old Navy', 'plaid-blazer.jpg', 'N', 'N'),
(13, 2, 'Denim Jacket', 'Blue', 'L', 'Like new', 'Coats', '45', 'Medium wash denim jacket.', 'Levi&#39;s', 'denim-jacket.jpg', 'N', 'N'),
(14, 2, 'Bohemian Mini Dress', 'Orange', 'XS', 'Like new', 'Dress', '20', 'Bohemian orange mini dress with open back', 'Urban Outfitters', 'boho-dress.jpg', 'N', 'N'),
(15, 2, 'Paisley Scarf', 'Multi', 'M', 'Good', 'Accessories', '15', 'Green and brown long paisley scarf with fringe', 'Pasumina', 'paisley-scarf.jpg', 'N', 'N'),
(16, 2, 'Floral Off The Shoulder Maxi Dress', 'Multi', 'XS', 'New (with tags)', 'Dress', '50', 'Blue floral maxi dress off the shoulder', 'Guess', 'floral-maxi.jpg', 'N', 'N'),
(17, 2, 'Blue Mom Jeans', 'Blue', 'XS', 'Good', 'Bottoms', '25', 'Blue light-wash vintage mom jeans with no rips', 'Zara', 'vintage-jeans.jpg', 'N', 'N'),
(18, 2, 'Floral Peplum Blouse', 'Pink', 'XS', 'Good', 'Tops', '15', 'Pink floral long-sleeve peplum blouse with tie neck', 'American Eagle', 'floral-blouse.jpg', 'N', 'N'),
(19, 2, 'Plaid Trousers', 'Brown', 'S', 'Good', 'Bottoms', '20', 'Low-rise plaid trousers', 'Gap', 'plaid-pants.jpg', 'N', 'N'),
(20, 2, 'Superman Hoodie', 'Multi', 'XS', 'Good', 'Tops', '20', 'Superman Hoodie with graphic hood', 'Comic', 'superman-hoodie.jpg', 'N', 'N'),
(21, 2, 'Wool Tan Coat', 'Brown', 'XS', 'Like new', 'Coats', '200', 'Wool tan coat with belt', 'Aritzia', 'wool-coat.jpg', 'N', 'N'),
(22, 2, 'Small Vegan-leather Crossbody Bag', 'Brown', 'S', 'Like new', 'Accessories', '50', 'Small vegan-leather crossbody bag with detachable straps', 'Matt & Nat', 'mini-bag.jpg', 'N', 'N'),
(23, 2, 'Plaid Pencil Skirt', 'Brown', 'S', 'Good', 'Bottoms', '20', 'Brown plaid pencil skirt with back slit', 'Tristan', 'plain-pencil-skirt.jpg', 'N', 'N'),
(24, 2, 'Satin Midi Skirt', 'Purple', 'M', 'Like new', 'Bottoms', '25', 'Satin purple midi skirt with back zipper', 'Frank + Oak', 'purple-skirt.jpg', 'N', 'N'),
(25, 2, 'Mini Skirt', 'Brown', 'XS', 'Good', 'Bottoms', '20', 'Wool mini skirt with back zipper', 'Beechers Brook', 'wool-mini-skirt.jpg', 'N', 'N'),
(26, 2, 'Tan Sandals', 'Brown', 'XS', 'Like new', 'Shoes', '60', 'Tan block heel sandals', 'Steve Madden', 'brown-sandals.jpg', 'N', 'N'),
(27, 2, 'Hiking Shoes', 'Brown', 'S', 'Like new', 'Shoes', '100', 'Durable hiking shoes with full grain leather and a supportive midsole and outsole', 'Merrell', 'hiking-shoes.jpg', 'N', 'N'),
(28, 2, 'Puffed Sleeve Sweater', 'Brown', 'S', 'Good', 'Tops', '30', 'Puffed long-sleeve tan crewneck sweater', 'Abercrombie & Fitch', 'tan-sweater.jpg', 'N', 'N'),
(29, 2, 'Winter Boots', 'Brown', 'S', 'Good', 'Shoes', '110', 'Mind-calf winter boots with sheepskin lining', 'UGGs', 'winter-boots.jpg', 'N', 'N'),
(30, 2, 'Travel Crossbody Bag', 'Black', 'S', 'Good', 'Accessories', '55', 'Black travel crossbody bag with anti-theft zipper', 'Travelon', 'black-bag.jpg', 'N', 'N'),
(31, 2, 'Ripped Jeans', 'Blue', 'XS', 'Like new', 'Bottoms', '50', 'Vintage ripped jeans with frame detailing', 'Abercrombie & Fitch', 'ripped-jeans.jpg', 'N', 'N'),
(32, 2, 'Sports Hat', 'Other', 'XS', 'Fair', 'Accessories', '15', 'Waterproof sports hat', 'The North Face', 'sports-hat.jpg', 'N', 'N'),
(33, 2, 'Winter Hat', 'Pink', 'XS', 'Good', 'Accessories', '15', 'Pink winter hat with ear covers', 'Old Navy', 'winter-hat.jpg', 'N', 'N'),
(34, 2, 'Bohemian Slouchy Crossbody Bag', 'Multi', 'L', 'Good', 'Accessories', '40', 'Bohemian slouchy crossbody bag with wooden button closure and medium pocket inside', 'Handmade', 'boho-bag.jpg', 'N', 'N'),
(35, 2, 'Vintage Shirt', 'Brown', 'S', 'Good', 'Tops', '25', 'Vintage buttoned-up shirt with collars', 'Unknown', 'old-shirt.jpg', 'N', 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `thrift`
--
ALTER TABLE `thrift`
  ADD PRIMARY KEY (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `thrift`
--
ALTER TABLE `thrift`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
