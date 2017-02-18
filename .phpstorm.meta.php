<?php
	namespace PHPSTORM_META {
	/** @noinspection PhpUnusedLocalVariableInspection */
	/** @noinspection PhpIllegalArrayKeyTypeInspection */
	$STATIC_METHOD_TYPES = [

		\D('') => [
			'Mongo' instanceof Think\Model\MongoModel,
			'Configure' instanceof Common\Model\ConfigureModel,
			'View' instanceof Think\Model\ViewModel,
			'Code' instanceof Common\Model\CodeModel,
			'Config' instanceof Common\Model\ConfigModel,
			'AuthRule' instanceof Common\Model\AuthRuleModel,
			'Img' instanceof Common\Model\ImgModel,
			'Mark' instanceof Common\Model\MarkModel,
			'ConfigSign' instanceof Common\Model\ConfigSignModel,
			'Profile' instanceof Common\Model\ProfileModel,
			'AuthGroupAccess' instanceof Common\Model\AuthGroupAccessModel,
			'Adv' instanceof Think\Model\AdvModel,
			'About' instanceof Common\Model\AboutModel,
			'Relation' instanceof Think\Model\RelationModel,
			'User' instanceof Common\Model\UserModel,
			'Common' instanceof Common\Model\CommonModel,
			'Merge' instanceof Think\Model\MergeModel,
			'AuthGroup' instanceof Common\Model\AuthGroupModel,
		],
	];
}