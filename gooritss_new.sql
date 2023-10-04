/*
 Navicat Premium Data Transfer

 Source Server         : local db
 Source Server Type    : MySQL
 Source Server Version : 80026 (8.0.26)
 Source Host           : localhost:3306
 Source Schema         : gooritss_db_new

 Target Server Type    : MySQL
 Target Server Version : 80026 (8.0.26)
 File Encoding         : 65001

 Date: 05/10/2023 06:36:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for car
-- ----------------------------
DROP TABLE IF EXISTS `car`;
CREATE TABLE `car`  (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of car
-- ----------------------------
INSERT INTO `car` VALUES ('ce2fba83-b143-4ec8-adad-9ddfbbfed26f', 'SUV');

-- ----------------------------
-- Table structure for car_components
-- ----------------------------
DROP TABLE IF EXISTS `car_components`;
CREATE TABLE `car_components`  (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `car_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `raw_components_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `raw_component_qty` int NOT NULL,
  PRIMARY KEY (`id`, `car_id`, `raw_components_id`) USING BTREE,
  INDEX `fk_car_has_raw_components_raw_components1_idx`(`raw_components_id` ASC) USING BTREE,
  INDEX `fk_car_has_raw_components_car1_idx`(`car_id` ASC) USING BTREE,
  CONSTRAINT `fk_car_has_raw_components_car1` FOREIGN KEY (`car_id`) REFERENCES `car` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_car_has_raw_components_raw_components1` FOREIGN KEY (`raw_components_id`) REFERENCES `raw_components` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of car_components
-- ----------------------------
INSERT INTO `car_components` VALUES ('93826fac-1ff0-4c9f-a198-2144de26b6f0', 'ce2fba83-b143-4ec8-adad-9ddfbbfed26f', '20b6df1f-d200-409a-9e49-c1385990ef53', 6);

-- ----------------------------
-- Table structure for component_has_other_component
-- ----------------------------
DROP TABLE IF EXISTS `component_has_other_component`;
CREATE TABLE `component_has_other_component`  (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `parent_component_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `child_component_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `component_qty` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_parent_component_idx`(`parent_component_id` ASC) USING BTREE,
  INDEX `fk_child_component_idx`(`child_component_id` ASC) USING BTREE,
  CONSTRAINT `fk_child_component` FOREIGN KEY (`child_component_id`) REFERENCES `raw_components` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_parent_component` FOREIGN KEY (`parent_component_id`) REFERENCES `raw_components` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of component_has_other_component
-- ----------------------------
INSERT INTO `component_has_other_component` VALUES ('17ec3d7c-4457-4931-9180-4bd8c660f08c', '20b6df1f-d200-409a-9e49-c1385990ef53', '1de831bc-5837-404e-9bff-ac17c1f56847', 4);
INSERT INTO `component_has_other_component` VALUES ('44965d75-f8ac-414e-9204-c4a849936b72', '20b6df1f-d200-409a-9e49-c1385990ef53', 'b3cf537d-f49d-4608-a49a-5b9e9396a014', 4);
INSERT INTO `component_has_other_component` VALUES ('512d59a6-594b-4670-b0f8-f0c3836c2e46', '20b6df1f-d200-409a-9e49-c1385990ef53', 'f774858b-3483-479f-b4ff-c641bcb826f5', 4);

-- ----------------------------
-- Table structure for production_plans
-- ----------------------------
DROP TABLE IF EXISTS `production_plans`;
CREATE TABLE `production_plans`  (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of production_plans
-- ----------------------------

-- ----------------------------
-- Table structure for raw_components
-- ----------------------------
DROP TABLE IF EXISTS `raw_components`;
CREATE TABLE `raw_components`  (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `stock` int NOT NULL,
  `production_cost` decimal(19, 2) NOT NULL,
  `production_time` int NOT NULL,
  `default_qty` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of raw_components
-- ----------------------------
INSERT INTO `raw_components` VALUES ('1de831bc-5837-404e-9bff-ac17c1f56847', 'Ban Luar', 50, 50000.00, 1, 4);
INSERT INTO `raw_components` VALUES ('20b6df1f-d200-409a-9e49-c1385990ef53', 'Ban', 100, 1100000.00, 12, 4);
INSERT INTO `raw_components` VALUES ('4e3ba366-8aff-4340-b0c1-6b3c82d16049', 'Pintu', 20, 2000000.00, 2, 4);
INSERT INTO `raw_components` VALUES ('b3cf537d-f49d-4608-a49a-5b9e9396a014', 'Ban Dalam', 50, 50000.00, 1, 4);
INSERT INTO `raw_components` VALUES ('f65cf02d-03b9-4e46-ac40-e3a2ba2c9bf9', 'Mesin', 50, 500000.00, 15, 2);
INSERT INTO `raw_components` VALUES ('f774858b-3483-479f-b4ff-c641bcb826f5', 'Velg', 30, 1000000.00, 10, 4);

-- ----------------------------
-- Table structure for raw_components_materials
-- ----------------------------
DROP TABLE IF EXISTS `raw_components_materials`;
CREATE TABLE `raw_components_materials`  (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `raw_material_qty` int NOT NULL,
  `raw_component_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `raw_material_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`, `raw_component_id`, `raw_material_id`) USING BTREE,
  INDEX `fk_products_has_raw_materials_raw_materials1_idx`(`raw_material_id` ASC) USING BTREE,
  INDEX `fk_products_has_raw_materials_products1_idx`(`raw_component_id` ASC) USING BTREE,
  CONSTRAINT `fk_products_has_raw_materials_products1` FOREIGN KEY (`raw_component_id`) REFERENCES `raw_components` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_products_has_raw_materials_raw_materials1` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of raw_components_materials
-- ----------------------------
INSERT INTO `raw_components_materials` VALUES ('1218cd5e-f189-4703-97a0-b03624ade203', 10, 'b3cf537d-f49d-4608-a49a-5b9e9396a014', 'aa34c3a9-107b-452d-8c99-c3a068cd463e');
INSERT INTO `raw_components_materials` VALUES ('13eeaeab-1e50-4461-960b-87affc94068f', 50, 'f774858b-3483-479f-b4ff-c641bcb826f5', '6fe5b88c-2d28-439a-8054-0c32b7923887');
INSERT INTO `raw_components_materials` VALUES ('286c3d4c-289b-44c8-bbfd-dc79d51a603d', 10, '20b6df1f-d200-409a-9e49-c1385990ef53', 'aa34c3a9-107b-452d-8c99-c3a068cd463e');
INSERT INTO `raw_components_materials` VALUES ('bda501b8-c62d-4c6d-b7a2-a53f091402f0', 10, '1de831bc-5837-404e-9bff-ac17c1f56847', 'aa34c3a9-107b-452d-8c99-c3a068cd463e');
INSERT INTO `raw_components_materials` VALUES ('cd0d3da4-b4df-4b0e-bdac-f151597e1402', 4, 'f65cf02d-03b9-4e46-ac40-e3a2ba2c9bf9', '6fe5b88c-2d28-439a-8054-0c32b7923887');
INSERT INTO `raw_components_materials` VALUES ('e501f802-be7d-42ad-9276-2de8b32c2127', 10, '4e3ba366-8aff-4340-b0c1-6b3c82d16049', '6fe5b88c-2d28-439a-8054-0c32b7923887');

-- ----------------------------
-- Table structure for raw_materials
-- ----------------------------
DROP TABLE IF EXISTS `raw_materials`;
CREATE TABLE `raw_materials`  (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of raw_materials
-- ----------------------------
INSERT INTO `raw_materials` VALUES ('6fe5b88c-2d28-439a-8054-0c32b7923887', 'Besi', 100);
INSERT INTO `raw_materials` VALUES ('aa34c3a9-107b-452d-8c99-c3a068cd463e', 'Karet', 100);
INSERT INTO `raw_materials` VALUES ('b53ea750-33ed-452c-9067-966cd153c806', 'Besi', 100);

SET FOREIGN_KEY_CHECKS = 1;
