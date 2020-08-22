-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22-Ago-2020 às 16:09
-- Versão do servidor: 10.4.13-MariaDB
-- versão do PHP: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fake-social-media`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `posts`
--

CREATE TABLE `posts` (
  `id` int(30) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED DEFAULT NULL,
  `title` tinytext DEFAULT NULL,
  `media` text DEFAULT NULL,
  `post_text` text DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `posts`
--

INSERT INTO `posts` (`id`, `id_user`, `title`, `media`, `post_text`, `created`) VALUES
(1, 1, 'Hello there', NULL, '\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum malesuada orci ipsum, vitae dignissim elit sodales a. Aliquam erat diam, pellentesque eu enim sed, commodo eleifend nibh. Vivamus eget est leo. Mauris sit amet hendrerit dolor. In eu erat dui. Maecenas diam odio, iaculis at viverra nec, fringilla consequat erat. Vestibulum pretium ligula eget orci aliquam malesuada. Sed consectetur non magna vel scelerisque. Nam egestas, sapien ac consectetur congue, felis arcu euismod dolor, vitae bibendum leo nibh non quam. Sed vulputate, lacus et posuere sagittis, urna urna mollis nunc, eget tristique eros orci sed dui. In posuere finibus ante, sit amet faucibus lectus. Ut ante lorem, dictum eget consectetur ut, interdum vitae leo. Proin volutpat malesuada sapien, a ornare felis ultricies nec. Vivamus ultrices suscipit turpis, id luctus metus semper eu. Aliquam erat volutpat. Aliquam erat volutpat. ', '2020-08-18 18:54:24'),
(2, 1, 'General Kenobi', NULL, '\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum malesuada orci ipsum, vitae dignissim elit sodales a. Aliquam erat diam, pellentesque eu enim sed, commodo eleifend nibh. Vivamus eget est leo. Mauris sit amet hendrerit dolor. In eu erat dui. Maecenas diam odio, iaculis at viverra nec, fringilla consequat erat. Vestibulum pretium ligula eget orci aliquam malesuada. Sed consectetur non magna vel scelerisque. Nam egestas, sapien ac consectetur congue, felis arcu euismod dolor, vitae bibendum leo nibh non quam. Sed vulputate, lacus et posuere sagittis, urna urna mollis nunc, eget tristique eros orci sed dui. In posuere finibus ante, sit amet faucibus lectus. Ut ante lorem, dictum eget consectetur ut, interdum vitae leo. Proin volutpat malesuada sapien, a ornare felis ultricies nec. Vivamus ultrices suscipit turpis, id luctus metus semper eu. Aliquam erat volutpat. Aliquam erat volutpat. ', '2020-08-18 18:54:30'),
(3, 1, 'You are a bold one!', NULL, '\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum malesuada orci ipsum, vitae dignissim elit sodales a. Aliquam erat diam, pellentesque eu enim sed, commodo eleifend nibh. Vivamus eget est leo. Mauris sit amet hendrerit dolor. In eu erat dui. Maecenas diam odio, iaculis at viverra nec, fringilla consequat erat. Vestibulum pretium ligula eget orci aliquam malesuada. Sed consectetur non magna vel scelerisque. Nam egestas, sapien ac consectetur congue, felis arcu euismod dolor, vitae bibendum leo nibh non quam. Sed vulputate, lacus et posuere sagittis, urna urna mollis nunc, eget tristique eros orci sed dui. In posuere finibus ante, sit amet faucibus lectus. Ut ante lorem, dictum eget consectetur ut, interdum vitae leo. Proin volutpat malesuada sapien, a ornare felis ultricies nec. Vivamus ultrices suscipit turpis, id luctus metus semper eu. Aliquam erat volutpat. Aliquam erat volutpat. ', '2020-08-18 18:54:36'),
(4, 2, 'When the darkness falls', NULL, '\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum malesuada orci ipsum, vitae dignissim elit sodales a. Aliquam erat diam, pellentesque eu enim sed, commodo eleifend nibh. Vivamus eget est leo. Mauris sit amet hendrerit dolor. In eu erat dui. Maecenas diam odio, iaculis at viverra nec, fringilla consequat erat. Vestibulum pretium ligula eget orci aliquam malesuada. Sed consectetur non magna vel scelerisque. Nam egestas, sapien ac consectetur congue, felis arcu euismod dolor, vitae bibendum leo nibh non quam. Sed vulputate, lacus et posuere sagittis, urna urna mollis nunc, eget tristique eros orci sed dui. In posuere finibus ante, sit amet faucibus lectus. Ut ante lorem, dictum eget consectetur ut, interdum vitae leo. Proin volutpat malesuada sapien, a ornare felis ultricies nec. Vivamus ultrices suscipit turpis, id luctus metus semper eu. Aliquam erat volutpat. Aliquam erat volutpat. ', '2020-08-18 18:55:04'),
(5, 2, 'And Arabia calls', NULL, '\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum malesuada orci ipsum, vitae dignissim elit sodales a. Aliquam erat diam, pellentesque eu enim sed, commodo eleifend nibh. Vivamus eget est leo. Mauris sit amet hendrerit dolor. In eu erat dui. Maecenas diam odio, iaculis at viverra nec, fringilla consequat erat. Vestibulum pretium ligula eget orci aliquam malesuada. Sed consectetur non magna vel scelerisque. Nam egestas, sapien ac consectetur congue, felis arcu euismod dolor, vitae bibendum leo nibh non quam. Sed vulputate, lacus et posuere sagittis, urna urna mollis nunc, eget tristique eros orci sed dui. In posuere finibus ante, sit amet faucibus lectus. Ut ante lorem, dictum eget consectetur ut, interdum vitae leo. Proin volutpat malesuada sapien, a ornare felis ultricies nec. Vivamus ultrices suscipit turpis, id luctus metus semper eu. Aliquam erat volutpat. Aliquam erat volutpat. ', '2020-08-18 18:55:10'),
(6, 1, 'Ha ha ha', NULL, '\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum malesuada orci ipsum, vitae dignissim elit sodales a. Aliquam erat diam, pellentesque eu enim sed, commodo eleifend nibh. Vivamus eget est leo. Mauris sit amet hendrerit dolor. In eu erat dui. Maecenas diam odio, iaculis at viverra nec, fringilla consequat erat. Vestibulum pretium ligula eget orci aliquam malesuada. Sed consectetur non magna vel scelerisque. Nam egestas, sapien ac consectetur congue, felis arcu euismod dolor, vitae bibendum leo nibh non quam. Sed vulputate, lacus et posuere sagittis, urna urna mollis nunc, eget tristique eros orci sed dui. In posuere finibus ante, sit amet faucibus lectus. Ut ante lorem, dictum eget consectetur ut, interdum vitae leo. Proin volutpat malesuada sapien, a ornare felis ultricies nec. Vivamus ultrices suscipit turpis, id luctus metus semper eu. Aliquam erat volutpat. Aliquam erat volutpat. ', '2020-08-18 18:55:26'),
(7, NULL, 'Don\'t delete me!', NULL, ' ', '2020-08-18 18:56:25'),
(14, 2, 'dasklsadlkasdkl', NULL, 'asdlakldladskladskl', '2020-08-19 00:40:27'),
(17, NULL, 'Zummy!', NULL, 'Zummy here.', '2020-08-19 01:33:03'),
(23, 1, 'adssad', NULL, 'adasdads', '2020-08-19 09:25:43'),
(26, 1, 'adasdasdasdsa', NULL, 'kkkkkkkkkkkkkkk', '2020-08-19 09:30:31'),
(28, 1, 'asdasdasdadsasd', NULL, 'adasdasdasdadasdadad', '2020-08-19 09:54:28'),
(39, 7, 'adasda', NULL, '', '2020-08-22 06:03:53'),
(40, 7, 'sadads', NULL, '', '2020-08-22 06:04:00'),
(41, 7, 'adsasdadasd', NULL, '', '2020-08-22 06:05:49'),
(42, 7, 'asdadsad', NULL, '', '2020-08-22 06:08:40'),
(43, 7, 'asdadsad', NULL, '', '2020-08-22 06:09:25'),
(44, 7, 'adsadsdada', NULL, 'sdadsad', '2020-08-22 06:09:56'),
(45, 7, 'adsadsad', NULL, 'sdadsasd', '2020-08-22 06:10:19'),
(54, 16, 'dasladskadsl', NULL, 'ladsklaskdklads', '2020-08-22 10:03:17'),
(55, 16, 'adskladslladsk', NULL, 'laskdkladsklsadl', '2020-08-22 10:03:28'),
(56, 7, 'kadslasldkadslk', NULL, 'laskdlkasdlk', '2020-08-22 10:03:50'),
(57, 7, 'akdslaldsladks', NULL, 'lkasdladskl', '2020-08-22 10:03:55'),
(58, 7, 'adasddas', NULL, 'asdasdadsads', '2020-08-22 10:03:59'),
(59, 7, 'ladkslakdslaskd', NULL, 'asllakdskls', '2020-08-22 10:09:54'),
(60, 7, 'adsasd', NULL, '', '2020-08-22 10:09:58'),
(61, 7, 'asdasdad', NULL, 'adsadasdasdd', '2020-08-22 11:07:38'),
(62, 7, 'adasdad', NULL, 'adsadsasd', '2020-08-22 11:08:31'),
(63, 7, 'asdasasdasd', NULL, 'sadadskladsl asdllkasdklaskladsdklasasdlasd kladskladskladskl', '2020-08-22 11:08:44'),
(64, 7, 'asdas', NULL, 'adskajdskjads adsjadkjsjkadsjads adsjkadskjjadskjakdskjads', '2020-08-22 11:09:30'),
(65, 7, 'adasdasd', NULL, 'adsadsasdads', '2020-08-22 11:10:30'),
(66, 7, 'Dictum ', NULL, 'Ultricies ', '2020-08-22 11:10:57'),
(67, 7, 'Facilisis.', NULL, 'Adipiscing hac commodo nisi faucibus.', '2020-08-22 11:17:07'),
(68, 7, 'Risus.', NULL, 'Orci id risus.Sodales netus maecenas.', '2020-08-22 11:17:08'),
(69, 7, 'Scelerisque.', NULL, 'Malesuada justo scelerisque augue diam rhoncus praesent vestibulum.', '2020-08-22 11:17:37'),
(70, 7, 'Quisque in porttitor.', NULL, 'Tellus pulvinar eu lobortis aliquam vivamus. Odio litora facilisis amet natoque malesuada dui consectetur etiam fusce semper. Malesuada.', '2020-08-22 11:17:46'),
(71, 7, 'Hac finibus mi.', NULL, 'Mi maecenas elit vulputate morbi in odio ullamcorper sem praesent conubia vivamus nisi at. Pretium taciti neque sed morbi orci ac ut nibh eleifend. Erat nascetur id pretium tellus aliquet nibh in fusce.\\nPlatea.', '2020-08-22 11:18:44'),
(72, 7, 'Sodales arcu.', NULL, 'Accumsan porttitor venenatis quis mollis mi adipiscing phasellus porta fames tincidunt risus parturient fusce sit dolor ultricies.', '2020-08-22 11:20:40'),
(73, 7, 'Class lorem.', NULL, 'Donec aptent tristique.', '2020-08-22 11:21:20'),
(74, 7, 'Lorem porta.', NULL, 'Est mi phasellus himenaeos. In lobortis lectus fermentum orci sapien himenaeos lorem per pretium accumsan auctor cubilia nunc. Lectus sapien.\\nCubilia ac leo aliquam vel tempor leo mauris dignissim purus dictum velit ipsum aliquam ut consequat. Efficitur nulla pharetra. Odio senectus congue aliquam purus justo fringilla nunc. Ultricies penatibus egestas class hendrerit. Ut ut erat habitant arcu massa. Sapien ante semper vehicula malesuada posuere id cursus fusce a neque adipiscing imperdiet eros. Lacinia.', '2020-08-22 11:21:39'),
(75, 7, 'Rhoncus.', NULL, 'Dictum mattis commodo massa penatibus. Elit montes rutrum interdum proin efficitur curae libero hac felis molestie consectetur adipiscing ipsum posuere. Vitae tempor ex id arcu neque lacinia cubilia dolor tristique donec.\\nEgestas curabitur volutpat donec.', '2020-08-22 11:21:50'),
(76, 7, 'Pharetra.', NULL, 'Hac diam condimentum dui habitant purus finibus blandit himenaeos dolor convallis. Dictum erat phasellus volutpat sed phasellus posuere porta praesent orci pellentesque phasellus nostra sed. Ornare torquent posuere mattis morbi nunc dui sapien est morbi dis aenean sed commodo per. Fermentum praesent in luctus metus lorem id lobortis nulla malesuada at mollis aliquet parturient. Turpis aenean lorem senectus elementum. Eros euismod nisl fermentum taciti vitae vestibulum pretium commodo elit tempus maximus.', '2020-08-22 11:22:05'),
(77, 7, 'Ad viverra.', NULL, 'Eros sagittis class arcu viverra porttitor malesuada elit in maximus efficitur mus faucibus tempor ipsum porta maximus. Mus per nulla libero id nulla justo posuere. Lorem quis ex nullam odio magna inceptos ante lorem a suspendisse eget ut aptent at nec condimentum conubia purus rhoncus. At leo.', '2020-08-22 11:22:11'),
(78, 7, 'Accumsan.', NULL, 'Mollis orci suscipit sagittis dictum conubia mi montes lacus dignissim venenatis. Varius mattis class nascetur suspendisse leo maximus nunc duis primis elementum senectus facilisis ad iaculis dis dictumst sapien. Primis varius eleifend id litora placerat vestibulum nullam. Vestibulum accumsan cursus nisl. Ornare quis consectetur maecenas.', '2020-08-22 11:22:27'),
(79, 7, 'Lorem parturient.', NULL, 'Posuere eros neque euismod neque et nullam lacinia faucibus purus risus feugiat euismod blandit tempus. Mauris duis sem nibh curae luctus venenatis penatibus turpis suspendisse.\\nSed hendrerit auctor sit facilisis.', '2020-08-22 11:22:32'),
(80, 7, 'Vel nullam.', NULL, 'Mauris accumsan in rhoncus aliquam est molestie ipsum ridiculus interdum orci massa eget tempor eu. Quisque potenti turpis etiam magnis habitasse luctus erat donec varius platea. Feugiat congue nascetur cursus quisque eu vulputate morbi lobortis dapibus nascetur.', '2020-08-22 11:22:58'),
(81, 7, 'Magna litora.', NULL, 'Platea accumsan.', '2020-08-22 11:23:53'),
(82, 7, 'adsad', NULL, 'asdadsads', '2020-08-22 11:24:12'),
(83, 7, 'Lacinia fusce.', NULL, 'Fames molestie condimentum consectetur turpis tempus. Commodo leo ac phasellus curabitur aenean ante ut orci tincidunt auctor vestibulum interdum nascetur nostra penatibus justo amet odio vestibulum. Integer aliquam arcu enim consequat.', '2020-08-22 11:26:13'),
(84, 7, 'Finibus sem purus.', NULL, 'Mollis nullam consequat habitant libero purus pulvinar mattis sapien parturient aliquam gravida sed eleifend. Mi feugiat luctus dictumst cubilia a felis rhoncus dis. Dignissim et molestie lorem dignissim adipiscing ultricies conubia est potenti ullamcorper efficitur litora odio quis aenean auctor curabitur. Aliquam.', '2020-08-22 11:26:46'),
(85, 7, 'Efficitur.', NULL, 'Habitant cubilia tellus purus tincidunt dolor vestibulum hac ante platea curae vestibulum mollis orci risus felis semper tempus aliquam. Donec ullamcorper est augue etiam arcu sagittis turpis urna adipiscing curae eget cursus vehicula hac. Dui commodo pharetra taciti penatibus nisi posuere proin. Etiam natoque hendrerit per viverra suscipit. Ut litora ligula habitant sodales non lacinia massa morbi parturient torquent turpis feugiat primis. Mattis potenti eros ornare molestie ac. Eros mauris condimentum ac morbi enim ligula.\\nId fermentum.', '2020-08-22 11:28:54'),
(86, 7, 'Accumsan pellentesque.', NULL, 'Ut pellentesque venenatis natoque non non viverra class rhoncus curabitur iaculis lectus tempor elit turpis velit sed. Tincidunt fermentum at mauris nibh mattis justo habitasse conubia donec sollicitudin magna nibh aliquam semper rutrum feugiat consequat. Sagittis id netus parturient suspendisse eget nulla neque velit neque.\\nPlacerat suspendisse interdum eros consequat lorem.', '2020-08-22 11:29:29'),
(87, 7, 'Nec sagittis.', NULL, 'Ligula leo platea faucibus bibendum malesuada. Cursus dui mauris adipiscing ridiculus. Ultrices ante urna mollis per primis velit nisl aliquam fringilla bibendum sagittis fermentum.\\nSollicitudin vel eu auctor volutpat dictum risus non dignissim conubia vitae adipiscing proin. Lacinia torquent sed duis aenean nostra semper. Nisl dis ex mi volutpat accumsan pellentesque. Semper sodales lorem mattis fermentum ad libero. Nec platea lacus.', '2020-08-22 11:29:49'),
(88, 7, 'Mattis urna.', NULL, 'Fusce risus litora euismod. Himenaeos at nunc vitae mi risus lacus penatibus id fringilla accumsan sagittis eget duis quisque. Egestas ad litora nulla habitant commodo. Et mus accumsan pulvinar tristique tincidunt. Morbi mauris ipsum facilisis accumsan class platea dolor sapien odio penatibus dui mauris.', '2020-08-22 11:31:44'),
(89, 7, 'Sapien magna.', NULL, 'Neque bibendum auctor habitant erat id non sollicitudin elementum risus gravida. Risus accumsan interdum est dignissim odio natoque varius metus fermentum leo montes porta risus ut class erat. Phasellus cubilia ridiculus molestie nisi nibh euismod penatibus. Praesent ac porttitor libero molestie nostra vestibulum fames vestibulum ullamcorper natoque nullam dictum mollis aliquet aliquam. Nibh vulputate.\\nInterdum egestas aenean lobortis ad erat. Facilisi nam penatibus quis dis gravida est facilisis venenatis auctor sociosqu montes. Felis eu per dignissim facilisis vestibulum pretium consequat euismod.', '2020-08-22 11:34:43'),
(90, 7, 'Mauris feugiat.', NULL, 'Libero class interdum in ornare efficitur fringilla ut consequat primis dapibus vel libero suscipit. .', '2020-08-22 11:35:38'),
(91, 7, 'A mus arcu.', NULL, 'Habitasse elementum sociosqu mauris ipsum. .', '2020-08-22 11:38:20'),
(92, 7, 'Dolor sit.', NULL, 'Ex mollis lorem facilisis taciti rutrum. Natoque.', '2020-08-22 11:39:23'),
(93, 7, 'Senectus.', NULL, '.', '2020-08-22 11:45:04'),
(94, 7, 'Platea.', NULL, '.', '2020-08-22 11:45:15'),
(95, 7, 'Lacinia tempor elementum.', NULL, 'Suscipit pretium nascetur ultrices et odio nibh scelerisque vivamus interdum.', '2020-08-22 11:45:53'),
(96, 7, 'Massa.', NULL, 'Neque adipiscing posuere efficitur interdum sagittis ridiculus sed consequat lacinia torquent dictumst tincidunt tellus. Sapien metus nascetur ante aptent risus semper turpis. Ligula magnis mus lorem. Magnis fringilla pharetra ipsum conubia erat pharetra orci ante ex bibendum sociosqu penatibus at in aenean condimentum. Ligula sociosqu aptent ad torquent nulla sed euismod venenatis. Libero mus vulputate metus lobortis quam ultricies gravida. In tempus aenean habitant tristique curae torquent pellentesque suscipit ipsum nam hac est aptent eget aptent montes phasellus. ', '2020-08-22 11:46:22'),
(97, 7, 'Praesent sodales.', NULL, 'Habitasse ut aptent orci augue quis rhoncus felis ex primis dui nulla.', '2020-08-22 11:54:35'),
(98, 7, 'Habitasse condimentum.', NULL, 'Elit efficitur bibendum dictum scelerisque non sollicitudin porta feugiat platea aliquam urna ut odio cursus nunc ultricies. Elit felis augue mus sem ornare maximus curabitur phasellus imperdiet facilisi.<br>Hac metus imperdiet dictum auctor fermentum nostra habitasse tellus donec dictum sodales senectus dictum elit netus. Lobortis montes parturient nunc rhoncus pellentesque velit at. Euismod facilisis inceptos consectetur.', '2020-08-22 11:55:05'),
(99, 7, 'Sagittis nascetur.', NULL, 'Morbi mauris habitasse turpis orci malesuada mollis ut fames vestibulum venenatis nascetur hac. Tellus sed blandit tellus nullam faucibus venenatis rhoncus ut donec. Cursus tortor turpis.<br>Donec orci imperdiet. Fusce venenatis lorem enim leo ullamcorper quis ipsum scelerisque volutpat. Vivamus nisi tempor ultrices faucibus purus mattis tincidunt euismod diam dignissim tempus nullam id malesuada eu nunc aenean. Aenean tristique aenean eu consectetur eget aenean.', '2020-08-22 11:56:09'),
(100, 7, 'Interdum interdum.', NULL, 'Hac sapien odio nulla porta non tincidunt accumsan. Tincidunt.', '2020-08-22 12:02:13'),
(101, 7, 'Etiam facilisi.', NULL, 'Justo dis lectus ornare. Nam etiam torquent auctor ullamcorper ac ad curae ipsum facilisis suscipit sociosqu dui porttitor odio faucibus orci himenaeos.', '2020-08-22 12:02:34'),
(102, 7, 'Vestibulum efficitur vulputate laoreet per phasellus. Porttitor dolor aliquam est diam. Habitant hendrerit nibh. Sociosqu aptent aliquam congue condimentum rutrum fusce lorem id quam dui aliquam erat nulla et sed pulvinar habitasse metus. Turpis montes na', NULL, 'Morbi congue mi dapibus accumsan cursus. Suspendisse dolor lacinia proin dis pharetra ex justo nec mattis sodales arcu maximus lorem leo.<br>Quam velit et cubilia nisl fames suspendisse elementum iaculis consequat pretium dis in sapien inceptos donec elementum. Potenti arcu feugiat urna. Sem quisque torquent adipiscing auctor mauris viverra at elit elit vehicula interdum felis vestibulum.<br>Ridiculus ipsum ornare lorem mattis mollis per sodales taciti morbi id dignissim lorem fringilla interdum vestibulum fames tellus efficitur dis. Litora quisque ipsum penatibus morbi magnis ut nascetur aliquam mus gravida dis taciti pellentesque eros habitant eleifend leo litora. Cubilia nisi cras accumsan morbi eget egestas cursus nostra commodo pretium duis tortor conubia id ut dapibus imperdiet. Efficitur commodo ad vehicula nisi morbi ligula pretium cras litora nunc. In ac augue vitae ut suscipit fames laoreet fermentum eget.', '2020-08-22 12:04:17'),
(103, 7, 'adasdads', NULL, 'Tempus consequat dolor urna lacinia primis placerat lectus purus magnis aliquam felis himenaeos ac arcu aenean aenean nascetur. Facilisi nulla tincidunt aptent sed mi dui purus. Non ornare aptent aliquet finibus efficitur et tempor eros consectetur penatibus varius.\\nEfficitur pellentesque hac congue orci ut curabitur. Arcu curae quisque metus ullamcorper porta magnis mattis vel mus litora a tortor consequat primis consectetur faucibus nec ornare purus. Interdum diam nulla pretium. Blandit posuere potenti facilisis interdum faucibus venenatis tempor euismod adipiscing. Dignissim natoque.', '2020-08-22 12:28:31'),
(104, 7, 'Tortor suspendisse.', NULL, 'Vitae ex vivamus convallis.', '2020-08-22 12:34:46'),
(105, 7, 'Cras luctus.', NULL, 'Taciti magnis at taciti dis sem sapien nisl orci finibus feugiat cras pretium massa hac ligula. Facilisi nam et montes neque ullamcorper metus iaculis dapibus conubia. Magnis metus blandit himenaeos. Et porta a vehicula egestas nibh hac aliquet sapien sagittis at. Tristique magnis nibh orci mi fames cubilia phasellus convallis ac justo sapien fringilla. Enim eget justo at suscipit. Tempus viverra suscipit adipiscing faucibus ipsum arcu in mus. Diam in ornare.\\r\\nSem arcu erat maecenas fusce nisl varius eget ornare id tempor purus nec. Cursus interdum quisque dolor mauris. Lacinia hendrerit porttitor.', '2020-08-22 12:34:59'),
(106, 7, 'Massa.', NULL, 'Risus porta.', '2020-08-22 12:38:35');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` binary(60) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created`) VALUES
(1, 'mummy', 'mummy@gmail.com', 0x2432792431302476785433434d6838693477317836594f6266337a512e50635750516974734274354c4277754a433071512e7369634942366d525961, '2020-08-18 01:12:35'),
(2, 'dummy', 'dummy@example.com', 0x243279243130244266597534426634624a344e787061546d2e3956577570455a32505a7468616943484a7674556b4e4c725852666c493246584e5253, '2020-08-18 06:38:25'),
(7, 'rummy', 'rummy@example.com', 0x243279243130245a79436d797944614c39374c6b47416355394852684f6b7967754b54453348634a46676a73555a483770566d793350705646774965, '2020-08-18 22:45:56'),
(16, 'zummy', 'zummy@example.com', 0x243279243130246c71576d766b72386275506c7863423073706639382e7968786569387454754c35625734726961504d41473152743530706339302e, '2020-08-22 08:52:09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_authentication`
--

CREATE TABLE `users_authentication` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `token` blob NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `users_authentication`
--
ALTER TABLE `users_authentication`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(30) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `users_authentication`
--
ALTER TABLE `users_authentication`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `users_authentication`
--
ALTER TABLE `users_authentication`
  ADD CONSTRAINT `users_authentication_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
