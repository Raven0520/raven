<?php
	namespace PHPSTORM_META {
	/** @noinspection PhpUnusedLocalVariableInspection */
	/** @noinspection PhpIllegalArrayKeyTypeInspection */
	$STATIC_METHOD_TYPES = [

		\D('') => [
			'Mongo' instanceof Think\Model\MongoModel,
			'Configure' instanceof Admin\Model\ConfigureModel,
			'View' instanceof Think\Model\ViewModel,
			'Code' instanceof Admin\Model\CodeModel,
			'Config' instanceof Admin\Model\ConfigModel,
			'AuthRule' instanceof Admin\Model\AuthRuleModel,
			'Img' instanceof Admin\Model\ImgModel,
			'Mark' instanceof Admin\Model\MarkModel,
			'ConfigSign' instanceof Admin\Model\ConfigSignModel,
			'AuthGroupAccess' instanceof Admin\Model\AuthGroupAccessModel,
			'Adv' instanceof Think\Model\AdvModel,
			'Relation' instanceof Think\Model\RelationModel,
			'User' instanceof Admin\Model\UserModel,
			'Common' instanceof Common\Model\CommonModel,
			'Merge' instanceof Think\Model\MergeModel,
			'AuthGroup' instanceof Admin\Model\AuthGroupModel,
		],
	];
}