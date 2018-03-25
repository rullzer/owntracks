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

namespace OCA\OwnTracks\Controller;

use OCA\OwnTracks\Db\LiveShareMapper;
use OCA\OwnTracks\Db\Location;
use OCA\OwnTracks\Db\LocationMapper;
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class ApiController extends \OCP\AppFramework\ApiController {

	/** @var LocationMapper */
	protected $locationMapper;

	/** @var LiveShareMapper */
	protected $liveShareMapper;

	/** @var string */
	protected $uid;

	public function __construct(string $appName,
								IRequest $request,
								LocationMapper $locationMapper,
								LiveShareMapper $liveShareMapper,
								string $userId) {
		parent::__construct($appName, $request, 'POST');

		$this->locationMapper = $locationMapper;
		$this->uid = $userId;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * @return DataResponse
	 */
	public function report(string $_type, float $lat, float $lon, int $tst) {

		if ($_type !== 'location') {
			return new DataResponse([]);
		}

		$location = new Location();
		$location->setUid($this->uid);
		$location->setLat($lat);
		$location->setLon($lon);
		$location->setTimestamp($tst);
		$this->locationMapper->insert($location);

		$data = [];
		$friends = $this->liveShareMapper->getFriends($this->uid);
		foreach ($friends as $friend) {
			try {
				$friendLocation = $this->locationMapper->getLastLocation($friend->getOwner());

				$data = [
					'_type' => 'location',
					'lat' => $friendLocation->getLat(),
					'lon' => $friendLocation->getLon(),
					'topic' => 'owntracks/' . $friendLocation->getUid(),
					'tst' => $friendLocation->getTimestamp(),
				];
			} catch (DoesNotExistException $e) {
				// Just continue
			}
		}

		return new DataResponse($data);
	}

}
