<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 未ログインユーザーはログイン画面にアクセスできること
     *
     * @test
     */
    public function not_login_user_can_see_a_login_form()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    /**
     * ログインユーザーはログインページにアクセスするとネタ一覧ページが表示されること
     *
     * @test
     */
    public function user_cannot_view_a_login_form_when_authenticated()
    {
        $user = factory(User::class)->state('FeatureTestUser')->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/scripts');
    }
    
    /**
     * ログインユーザーのパスワードと同じパスワードだとログインできること
     *
     * @test
     */
    public function user_can_login_with_correct_credentials()
    {
        $user = factory(User::class)->state('FeatureTestUser')->create([
            'password' => bcrypt($password = 'topSecret'),
        ]);
        
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password
        ]);
        
        $response->assertRedirect('/scripts');
        $this->assertAuthenticatedAs($user);
    }
    
    /**
     * ログインユーザーのパスワードと異なる値のパスワードだとログイン不可となること
     *
     * @test
     */
    public function user_cannot_login_with_wrong_credential()
    {
        $user = factory(User::class)->state('FeatureTestUser')->create([
            'password' => bcrypt('topSecret'),
        ]);

        $response = $this->from('/login')->post('/login',[
            'email' => $user->email,
            'password' => bcrypt('secret'),
        ]);

        $response->assertRedirect(('/login'));
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /**
     * 未ログインユーザーは新規登録画面にアクセスできること
     *
     * @test
     */
    public function not_login_user_can_see_a_sighup_form()
    {
        $response = $this->get('/register');

        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }

    /**
     * ログインユーザーは新規登録ページにアクセスするとネタ一覧ページが表示されること
     *
     * @test
     */
    public function user_cannot_view_a_signup_form_when_authenticated()
    {
        $user = factory(User::class)->state('FeatureTestUser')->make();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect('/scripts');
        $this->assertTrue(Auth::check());
    }
    
    /**
     * ユーザーを新規登録できること
     *
     * @test
     */
    public function user_registration_is_available()
    {
        $user = factory(User::class)->state('FeatureTestUser')->make();
        $response = $this->from('/register')->post('/register',[
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password,
        ]);
        
        $response->assertRedirect('/scripts');
        $this->assertTrue(Auth::check());
    }

    /**
     * 同じEmailアドレスで新規登録できないこと
     *
     * @test
     */
    public function user_registration_is_not_available_with_registrated_email()
    {
        $user = factory(User::class)->state('FeatureTestUser')->create();
    
        $password = 'topsecret';
        $response = $this->from('/register')->post('/register',[
            'name' => 'Alice',
            'email' => $user->email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);
        
        $response->assertRedirect('/register');
        $this->assertFalse(Auth::check());
    }

    /**
     * Emailアドレス欄を空欄で新規登録できないこと
     *
     * @test
     */
    public function user_registration_is_not_available_with_empty_email_form()
    {
        $user = factory(User::class)->state('FeatureTestUser')->make();
    
        $response = $this->from('/register')->post('/register',[
            'name' => $user->name,
            'email' => '',
            'password' => $user->password,
            'password_confirmation' => $user->password,
        ]);
        
        $response->assertRedirect('/register');
        $this->assertFalse(Auth::check());
    }

    /**
     * Emailアドレスのフォーマットに対応しないアドレスで新規登録できないこと
     *
     * @test
     */
    public function user_registration_is_not_available_with_invalid_format_email()
    {
        $user = factory(User::class)->state('FeatureTestUser')->make();
    
        $response = $this->from('/register')->post('/register',[
            'name' => $user->name,
            'email' => 'foo@bar+baz.com',
            'password' => $user->password,
            'password_confirmation' => $user->password,
        ]);
        
        $response->assertRedirect('/register');
        $this->assertFalse(Auth::check());
    }

    /**
     * パスワード欄が空欄だと新規登録できないこと
     *
     * @test
     */
    public function user_registration_is_not_available_with_empty_password_form()
    {
        $user = factory(User::class)->state('FeatureTestUser')->make();
    
        $response = $this->from('/register')->post('/register',[
            'name' => $user->name,
            'email' => $user->email,
            'password' => '',
            'password_confirmation' => $user->password,
        ]);
        
        $response->assertRedirect('/register');
        $this->assertFalse(Auth::check());
    }

    /**
     * パスワード確認欄が空欄だと新規登録できないこと
     *
     * @test
     */
    public function user_registration_is_not_available_with_empty_password_confirmation_form()
    {
        $user = factory(User::class)->state('FeatureTestUser')->make();
    
        $response = $this->from('/register')->post('/register',[
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => '',
        ]);
        
        $response->assertRedirect('/register');
        $this->assertFalse(Auth::check());
    }
    

}
