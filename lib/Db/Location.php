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

use OCP\AppFramework\Db\Entity;

/**
 * @method void setUid(string $uid)
 * @method string getUid()
 * @method void setLat(float $lat)
 * @method float getLat()
 * @method void setLon(float $lon)
 * @method float getLon()
 * @method void setTimestamp(int $timestamp)
 * @method int getTimestamp()
 *
 */
class Location extends Entity {

	/** @var string */
	protected $uid;

	/** @var float */
	protected $lat;

	/** @var float */
	protected $lon;

	/** @var int */
	protected $timestamp;

	public function __construct() {
		$this->addType('uid', 'string');
		$this->addType('lat', 'float');
		$this->addType('lon', 'float');
		$this->addType('timestamp' , 'int');
	}
}
