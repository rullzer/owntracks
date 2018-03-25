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

namespace OCA\OwnTracks\Db;

use OCP\AppFramework\Db\Mapper;
use OCP\IDBConnection;

class LiveShareMapper extends Mapper {

	public function __construct(IDBConnection $db) {
		parent::__construct($db, 'owntracks_live_share');
	}

	/**
	 * Get all the people that share their location with you
	 *
	 * @return LiveShare[]
	 */
	public function getFriends(string $recipient): array {
		$qb = $this->db->getQueryBuilder();

		$qb->select('*')
			->from('owntracks_live_share')
			->where(
				$qb->expr()->eq('recipient', $qb->createNamedParameter($recipient))
			);
		$result = $qb->execute();

		$data = [];
		while($row = $result->fetch()) {
			$data[] = LiveShare::fromRow($row);
		}
		$result->closeCursor();

		return $data;
	}
}
