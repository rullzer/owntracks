<?php
declare(strict_types=1);
/**
 * @copyright Copyright (c) 2018, Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @author Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\OwnTracks\Migration;

use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;

class Version000001Date20180325130012 extends SimpleMigrationStep {

	public function changeSchema(IOutput $output, \Closure $schemaClosure, array $options) {
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		$table = $schema->createTable('owntracks_location');
		$table->addColumn('id', 'bigint', [
			'autoincrement' => true,
			'notnull' => true,
			'length' => 11,
			'unsigned' => true,
		]);
		$table->addColumn('uid', 'string', [
			'notnull' => true,
			'length' => 255,
		]);
		$table->addColumn('lat', 'decimal', [
			'notnull' => true,
			'precision' => 9,
			'scale' => 6,
		]);
		$table->addColumn('lon', 'decimal', [
			'notnull' => true,
			'precision' => 9,
			'scale' => 6,
		]);
		$table->addColumn('timestamp', 'bigint', [
			'notnull' => true,
			'length' => 11,
			'unsigned' => true,
		]);
		$table->setPrimaryKey(['id']);
		$table->addIndex(['uid'], 'owntracks_l_uid');


		$table = $schema->createTable('owntracks_live_share');
		$table->addColumn('id', 'bigint', [
			'autoincrement' => true,
			'notnull' => true,
			'length' => 11,
			'unsigned' => true,
		]);
		$table->addColumn('owner', 'string', [
			'notnull' => true,
			'length' => 255,
		]);
		$table->addColumn('recipient', 'string', [
			'notnull' => true,
			'length' => 255,
		]);
		$table->setPrimaryKey(['id']);
		$table->addIndex(['owner'], 'owntracks_ls_owner');
		$table->addIndex(['recipient'], 'owntracks_ls_recipient');

		return $schema;
	}
}
