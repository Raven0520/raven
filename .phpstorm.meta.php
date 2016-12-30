<?php
	namespace PHPSTORM_META {
	/** @noinspection PhpUnusedLocalVariableInspection */
	/** @noinspection PhpIllegalArrayKeyTypeInspection */
	$STATIC_METHOD_TYPES = [

		\D('') => [
			'Adv' instanceof Think\Model\AdvModel,
			'Mongo' instanceof Think\Model\MongoModel,
			'View' instanceof Think\Model\ViewModel,
			'Relation' instanceof Think\Model\RelationModel,
			'AuthRule' instanceof Admin\Model\AuthRuleModel,
			'User' instanceof Admin\Model\UserModel,
			'Common' instanceof Common\Model\CommonModel,
			'Merge' instanceof Think\Model\MergeModel,
			'AuthGroup' instanceof Admin\Model\AuthGroupModel,
		],
	];
}