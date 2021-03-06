<?php

namespace tests\unit\modules\user\forms\frontend;

use app\modules\user\forms\frontend\EmailConfirmForm;
use Codeception\Test\Unit;
use tests\_fixtures\UserFixture;

class EmailConfirmFormTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/unit/_fixtures/data/user-email-confirm.php'
            ]
        ]);
    }

    public function testConfirmWrongToken()
    {
        $this->expectException('yii\base\InvalidParamException');
        new EmailConfirmForm('notexistingtoken_1391882543');
    }

    public function testConfirmEmptyToken()
    {
        $this->expectException('yii\base\InvalidParamException');
        new EmailConfirmForm('');
    }

    public function testConfirmCorrectToken()
    {
        $user = $this->tester->grabFixture('user', 0);
        $form = new EmailConfirmForm($user['email_confirm_token']);
        expect('email should be confirmed', $form->confirmEmail())->true();
    }
}
