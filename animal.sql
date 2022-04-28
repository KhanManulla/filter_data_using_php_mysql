

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `animal    ` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(50) 255 NULL,
  `description` varchar(255) NOT NULL,
  `life_expectancy` varchar(255) NOT NULL,
  `subdate` datetime NOT current_timestamp()	
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `id`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
