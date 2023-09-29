/*
 Navicat Premium Data Transfer

 Source Server         : local db
 Source Server Type    : MySQL
 Source Server Version : 80026 (8.0.26)
 Source Host           : localhost:3306
 Source Schema         : gooritss

 Target Server Type    : MySQL
 Target Server Version : 80026 (8.0.26)
 File Encoding         : 65001

 Date: 30/09/2023 01:18:34
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

-- ----------------------------
-- Table structure for car_components
-- ----------------------------
DROP TABLE IF EXISTS `car_components`;
CREATE TABLE `car_components`  (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `car_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `component_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `component_qty` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `car_id`, `component_id`) USING BTREE,
  INDEX `fk_car_has_components_components1_idx`(`component_id` ASC) USING BTREE,
  INDEX `fk_car_has_components_car1_idx`(`car_id` ASC) USING BTREE,
  CONSTRAINT `fk_car_has_components_car1` FOREIGN KEY (`car_id`) REFERENCES `car` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_car_has_components_components1` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of car_components
-- ----------------------------

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
  `required_qty` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of components
-- ----------------------------
INSERT INTO `components` VALUES ('69607775-29c2-428c-970f-4b36b674b9da', 'Mesin', 50, 200000.00, 20, 5);
INSERT INTO `components` VALUES ('7d58d5da-1cda-4c3c-bf21-2e5004160399', 'Baut', 40, 100000.00, 3, 30);
INSERT INTO `components` VALUES ('b89cedb6-b192-464d-93dc-d7e9c9c72f7a', 'Pintu', 100, 20000.00, 5, 4);

-- ----------------------------
-- Table structure for components_materials
-- ----------------------------
DROP TABLE IF EXISTS `components_materials`;
CREATE TABLE `components_materials`  (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `raw_material_qty` int NOT NULL,
  `component_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `raw_material_id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`, `component_id`, `raw_material_id`) USING BTREE,
  INDEX `fk_components_has_raw_materials_raw_materials1_idx`(`raw_material_id` ASC) USING BTREE,
  INDEX `fk_components_has_raw_materials_components_idx`(`component_id` ASC) USING BTREE,
  CONSTRAINT `fk_components_has_raw_materials_components` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_components_has_raw_materials_raw_materials1` FOREIGN KEY (`raw_material_id`) REFERENCES `raw_materials` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of components_materials
-- ----------------------------

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
INSERT INTO `raw_materials` VALUES ('0699203d-09d7-4517-b641-ee2786a2c16f', 'Plastik', 20);
INSERT INTO `raw_materials` VALUES ('0a41e1e8-8e46-4f33-83c1-32abccdc098c', 'Baja', 10);
INSERT INTO `raw_materials` VALUES ('2fb98911-fa2e-4e5c-98ea-8d095e55ae33', 'Besi', 50);
INSERT INTO `raw_materials` VALUES ('df89a2e4-e543-448b-a644-01b0bdcf2f22', 'Karet', 60);

SET FOREIGN_KEY_CHECKS = 1;
