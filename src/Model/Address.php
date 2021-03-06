<?php

/**
 * This file is part of the Geocoder package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Geocoder\Model;

use Geocoder\Location;

/**
 * @author William Durand <william.durand1@gmail.com>
 */
final class Address implements Location
{
    /**
     * @var Coordinates|null
     */
    private $coordinates;

    /**
     * @var Bounds|null
     */
    private $bounds;

    /**
     * @var string|int|null
     */
    private $streetNumber;

    /**
     * @var string|null
     */
    private $streetName;

    /**
     * @var string|null
     */
    private $subLocality;

    /**
     * @var string|null
     */
    private $locality;

    /**
     * @var string|null
     */
    private $postalCode;

    /**
     * @var string|null
     */
    private $locationType;


    /**
     * @var AdminLevelCollection
     */
    private $adminLevels;

    /**
     * @var Country|null
     */
    private $country;

    /**
     * @var string|null
     */
    private $timezone;

    /**
     *
     * @param Coordinates|null $coordinates
     * @param Bounds|null $bounds
     * @param string|null $streetNumber
     * @param string|null $streetName
     * @param string|null $postalCode
     * @param string|null $locationType
     * @param string|null $locality
     * @param string|null $subLocality
     * @param AdminLevelCollection|null $adminLevels
     * @param Country|null $country
     * @param string|null $timezone
     */
    public function __construct(
        Coordinates $coordinates          = null,
        Bounds $bounds                    = null,
        $streetNumber                     = null,
        $streetName                       = null,
        $postalCode                       = null,
        $locationType                     = null,
        $locality                         = null,
        $subLocality                      = null,
        AdminLevelCollection $adminLevels = null,
        Country $country                  = null,
        $timezone                         = null
    ) {
        $this->coordinates  = $coordinates;
        $this->bounds       = $bounds;
        $this->streetNumber = $streetNumber;
        $this->streetName   = $streetName;
        $this->postalCode   = $postalCode;
        $this->locationType = $locationType;
        $this->locality     = $locality;
        $this->subLocality  = $subLocality;
        $this->adminLevels  = $adminLevels ?: new AdminLevelCollection();
        $this->country      = $country;
        $this->timezone     = $timezone;
    }

    /**
     * {@inheritDoc}
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * {@inheritDoc}
     */
    public function getBounds()
    {
        return $this->bounds;
    }

    /**
     * {@inheritDoc}
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * {@inheritDoc}
     */
    public function getStreetName()
    {
        return $this->streetName;
    }

    /**
     * {@inheritDoc}
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * {@inheritDoc}
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * {@inheritDoc}
     */
    public function getLocationType()
    {
        return $this->locationType;
    }

    /**
     * {@inheritDoc}
     */
    public function getSubLocality()
    {
        return $this->subLocality;
    }

    /**
     * {@inheritDoc}
     */
    public function getAdminLevels()
    {
        return $this->adminLevels;
    }

    /**
     * {@inheritDoc}
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * {@inheritDoc}
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        $adminLevels = [];
        foreach ($this->adminLevels as $adminLevel) {
            $adminLevels[$adminLevel->getLevel()] = [
                'name'  => $adminLevel->getName(),
                'code'  => $adminLevel->getCode()
            ];
        }

        $lat = null;
        $lon = null;
        if (null !== $coordinates = $this->getCoordinates()) {
            $lat = $coordinates->getLatitude();
            $lon = $coordinates->getLongitude();
        }

        $countryName = null;
        $countryCode = null;
        if (null !== $country = $this->getCountry()) {
            $countryName = $country->getName();
            $countryCode = $country->getCode();
        }

        $noBounds = [
            'south' => null,
            'west'  => null,
            'north' => null,
            'east'  => null,
        ];

        return array(
            'latitude'     => $lat,
            'longitude'    => $lon,
            'bounds'       => null !== $this->bounds ? $this->bounds->toArray() : $noBounds,
            'streetNumber' => $this->streetNumber,
            'streetName'   => $this->streetName,
            'postalCode'   => $this->postalCode,
            'locality'     => $this->locality,
            'subLocality'  => $this->subLocality,
            'adminLevels'  => $adminLevels,
            'country'      => $countryName,
            'countryCode'  => $countryCode,
            'timezone'     => $this->timezone,
        );
    }
}
