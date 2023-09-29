/*
 Navicat Premium Data Transfer

 Source Server         : local db
 Source Server Type    : MySQL
 Source Server Version : 80026 (8.0.26)
 Source Host           : localhost:3306
 Source Schema         : gooritss_db

 Target Server Type    : MySQL
 Target Server Version : 80026 (8.0.26)
 File Encoding         : 65001

 Date: 28/09/2023 23:12:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for car_components
-- ----------------------------
DROP TABLE IF EXISTS `car_components`;
CREATE TABLE `car_components`  (
  `id` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `component_id` varchar(36) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of car_components
-- ----------------------------
INSERT INTO `car_components` VALUES ('48aef747-b724-4f1d-9344-82a7cc85efcd', '6ce9d64c-b0f5-42cd-865c-d5dc19afd8a2', 15);
INSERT INTO `car_components` VALUES ('8a63c1e2-e1fc-4cda-a21f-7ac31ccce336', '09b50fea-2311-47b4-9a5c-e163a172f913', 20);

-- ----------------------------
-- Table structure for components
-- ----------------------------
DROP TABLE IF EXISTS `components`;
CREATE TABLE `components`  (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `stock` int NOT NULL,
  `production_cost` decimal(19, 2) NOT NULL,
  `production_time` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of components
-- ----------------------------
INSERT INTO `components` VALUES ('09b50fea-2311-47b4-9a5c-e163a172f913', 'Ban', 455, 45.00, 435);
INSERT INTO `components` VALUES ('6ce9d64c-b0f5-42cd-865c-d5dc19afd8a2', 'Mesin', 40, 500000.00, 200);
INSERT INTO `components` VALUES ('e84911d8-441f-42bd-8f98-a0b0ef9e5622', 'ban', 500, 200000.00, 30);

-- ----------------------------
-- Table structure for components_materials
-- ----------------------------
DROP TABLE IF EXISTS `components_materials`;
CREATE TABLE `components_materials`  (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `component_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `raw_material_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `raw_material_qty` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `component_id`, `raw_material_id`) USING BTREE,
  INDEX `fk_components_has_raw_materials_raw_materials1_idx`(`raw_material_id` ASC) USING BTREE,
  INDEX `fk_components_has_raw_materials_components_idx`(`component_id` ASC) USING BTREE,
  CONSTRAINT `fk_components_has_raw_materials_components` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_components_has_raw_materials_raw_materials1` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of components_materials
-- ----------------------------
INSERT INTO `components_materials` VALUES ('31675acd-6e64-4c31-811f-5598f2e4b24c', '6ce9d64c-b0f5-42cd-865c-d5dc19afd8a2', '744cefb1-d70e-4572-a1b4-6b41f7f04aaa', 15);
INSERT INTO `components_materials` VALUES ('c0e9a7e4-7dcc-4681-af49-91e3e70c887f', '6ce9d64c-b0f5-42cd-865c-d5dc19afd8a2', '26ee7544-e293-44e3-9eda-1f3431abe5ae', 10);
INSERT INTO `components_materials` VALUES ('cd8c066e-6cb4-474d-8382-c7ddecf045ee', 'e84911d8-441f-42bd-8f98-a0b0ef9e5622', '81a3eef2-3a32-4b84-abcb-3b6b7f6dba6c', 5);
INSERT INTO `components_materials` VALUES ('eaedb38c-0a94-4796-8fad-1ee9bcc110ea', 'e84911d8-441f-42bd-8f98-a0b0ef9e5622', 'd5674000-67c8-47d7-8229-8901242ece93', 10);

-- ----------------------------
-- Table structure for production_plans
-- ----------------------------
DROP TABLE IF EXISTS `production_plans`;
CREATE TABLE `production_plans`  (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of production_plans
-- ----------------------------

-- ----------------------------
-- Table structure for raw_materials
-- ----------------------------
DROP TABLE IF EXISTS `raw_materials`;
CREATE TABLE `raw_materials`  (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of raw_materials
-- ----------------------------
INSERT INTO `raw_materials` VALUES ('26ee7544-e293-44e3-9eda-1f3431abe5ae', 'Baja', 89);
INSERT INTO `raw_materials` VALUES ('744cefb1-d70e-4572-a1b4-6b41f7f04aaa', 'Besi', 14);
INSERT INTO `raw_materials` VALUES ('81a3eef2-3a32-4b84-abcb-3b6b7f6dba6c', 'Karet', 23);
INSERT INTO `raw_materials` VALUES ('d1482f4a-d7d0-42b1-b143-4f355094592d', 'Glass', 34);
INSERT INTO `raw_materials` VALUES ('d5674000-67c8-47d7-8229-8901242ece93', 'Plastik', 23);

SET FOREIGN_KEY_CHECKS = 1;
