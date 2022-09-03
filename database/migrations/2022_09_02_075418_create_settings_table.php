<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateSettingsTable.
 */
class CreateSettingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->default('')->comment('名称');
            $table->string('key')->unique()->default('')->comment('配置键');
            $table->text('value')->comment('配置值');
            $table->enum('view_type',['text','number','select','select_multiple','radio','checkbox','textarea','file'])->default('text')->comment('界面显示类型');
            $table->text('options')->nullable()->comment('当view_type是select,select_multiple,radio,checkbox时，该值保存可选项,json串');
            $table->boolean('editable')->default(1)->comment('是否能编缉');
            $table->boolean('hide')->default(0)->comment('是否隐藏');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings');
	}
}
