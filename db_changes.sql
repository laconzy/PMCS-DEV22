/* End Bits Bundle Chart - Permission */
INSERT INTO `permission`(`permission_code`, `permission_name`, `permission_category`) VALUES ('PROD_END_BTS_CHART', 'End Bits Bundle Chart', 'CAT_PROD');

UPDATE menu_sub SET sub_menu_permission = 'PROD_END_BTS_CHART' WHERE sub_menu_code = 'SM_M_BUNDLE';

/* End Bits Mini Bundle Chart - Permission changes */
INSERT INTO `permission`(`permission_code`, `permission_name`, `permission_category`) VALUES ('PROD_END_MIN_CHART', 'End Bits Mini Bundle Chart', 'CAT_PROD');

UPDATE menu_sub SET sub_menu_permission = 'PROD_END_MIN_CHART' WHERE sub_menu_code = 'SM_M_MIN_BUNDLE';

/* new permission and menu for daily rejection report */
INSERT INTO `permission`(`permission_code`, `permission_name`, `permission_category`) VALUES ('REP_DLY_REJECTION', 'Daily Rejection Report', 'CAT_REPORT');
INSERT INTO `menu_sub`(`sub_menu_code`, `sub_menu_permission`, `order_no`, `sub_menu_name`, `sub_menu_parent`, `sub_menu_url`, `sub_menu_icon`) VALUES ('SM_DAILY_REJECTION', 'REP_DLY_REJECTION', 65, 'Daily Rejection Report', 'MENU_REPORT', 'index.php/report/daily_rejection_report', 'fa fa-angle-right pull-left');

/* queries for master reasons */
INSERT INTO `permission`(`permission_code`, `permission_name`, `permission_category`) VALUES ('MASTER_REASON', 'Manage Reason', 'CAT_MASTER');
INSERT INTO `menu_sub`(`sub_menu_code`, `sub_menu_permission`, `order_no`, `sub_menu_name`, `sub_menu_parent`, `sub_menu_url`, `sub_menu_icon`) VALUES ('SM_REASON', 'MASTER_REASON', 17, 'Reasons', 'MENU_MASTER', 'index.php/master/reason', 'fa fa-angle-right pull-left');

DROP TABLE IF EXISTS `reason_catrgory`;
CREATE TABLE `reason_catrgory`  (
  `category` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`category`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

INSERT INTO `reason_catrgory` VALUES ('REJECT', 1);
INSERT INTO `reason_catrgory` VALUES ('FG TRANSFER', 1);

DROP TABLE IF EXISTS `reason`;
CREATE TABLE `reason`  (
  `reason_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `reason_text` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `active` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y',
  `created_at` datetime(0) NOT NULL,
  `created_user` int(11) NOT NULL,
  `updated_at` datetime(0) NOT NULL,
  `updated_user` int(11) NOT NULL,
  PRIMARY KEY (`reason_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;


/* FG Transfer functionality */

DROP TABLE IF EXISTS `fg_transfer_header`;
CREATE TABLE `fg_transfer_header`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_order_id` int(11) NOT NULL,
  `to_order_id` int(11) NOT NULL,
  `transfered_date` datetime(0) NOT NULL,
  `transfered_user` int(11) NOT NULL,
  `transfer_reason` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 21 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Fixed;



/* B Stores Transfer -----------------------------------------------------------*/

INSERT INTO `permission`(`permission_code`, `permission_name`, `permission_category`) VALUES ('B_STORE_TRANSFER', 'B Stores Transfer', 'CAT_FG');

INSERT INTO `menu_sub`(`sub_menu_code`, `sub_menu_permission`, `order_no`, `sub_menu_name`, `sub_menu_parent`, `sub_menu_url`, `sub_menu_icon`) VALUES ('SM_B_STORE_TRANSFER', 'B_STORE_TRANSFER', 4, 'B Stores Transfer', 'MENU_FG', 'index.php/fg/bstores_transfer', 'fa fa-angle-right pull-left');

CREATE TABLE `bstores_transfer_header`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_order_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `transfered_date` datetime(0) NOT NULL,
  `transfered_user` int(11) NOT NULL,
  `transfer_reason` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 25 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Fixed;

CREATE TABLE `bstores_transfer_details`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `transfered_date` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 25 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Fixed;

INSERT INTO `reason_category`(`category`, `active`) VALUES ('B STORES FG TRANSFER', 1);

INSERT INTO `reason_category`(`category`, `active`) VALUES ('B STORES WRITE OF', 1);

ALTER TABLE `kiyamulk_pmcs`.`rejection`
ADD COLUMN `style_id` INT(11) NULL DEFAULT NULL AFTER `receive_location`,
ADD COLUMN `color_id` INT(11) NULL DEFAULT NULL AFTER `style_id`,
ADD COLUMN `transfer_id` INT(11) NULL DEFAULT NULL AFTER `color_id`;
ADD COLUMN `transfer_status` VARCHAR(45) NULL DEFAULT NULL AFTER `transfer_id`;

ALTER TABLE `kiyamulk_pmcs`.`bstores_transfer_header`
ADD COLUMN `transfer_type` VARCHAR(45) NULL AFTER `transfer_reason`;

ALTER TABLE `kiyamulk_pmcs`.`bstores_transfer_header`
CHANGE COLUMN `transfer_order_id` `transfer_order_id` INT(11) NULL ;


/* Change BINDING to FUSING */

UPDATE menu_sub SET sub_menu_name = 'Fusing' WHERE sub_menu_code = 'SM_PRO_BINDING';
UPDATE operation SET operation_name = 'FUSING' WHERE operation_id = 15;

/* add new line permission feature */

CREATE TABLE `permission_group_line_permissions` (
  `group_id` int(11) NOT NULL,
  `line_id` int(11) NOT NULL,
  KEY `FK_go0pa97h0ehffxtxlkgl3rg59` (`line_id`) USING BTREE,
  KEY `FK_gyufjuhsj0orb99huwicmnpnd` (`group_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* add style category to view_line_out */

`style`.`style_cat` AS `style_category`,

/* container packing list report */
SM_FG_CN_PACK_LIST	FG_PACK_LIST	1	Container Packing List	MENU_FG	index.php/fg/packing_list/fg_container_packing_list	fa fa-angle-right pull-left


/* add shift type to manual line out and cutting out */
ALTER TABLE production ADD shift_type varchar(10);

/* ORDER RECONCILIATION REPORT add complete status */
ALTER TABLE order_head ADD COLUMN is_complete TINYINT(1) DEFAULT 0;


/*mini bundle - add shift */
ALTER TABLE cut_bundles_2 ADD shift varchar(2);

/*End Bits Bundle - add shift */
ALTER TABLE cut_bundles ADD shift varchar(2);


/* remove hod column from departments table */

/* add new column to replacement_fabric_packinglist table in epac database */
ALTER TABLE replacement_fabric_packinglist ADD order_code varchar(255);
