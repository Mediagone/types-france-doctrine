<?php declare(strict_types=1);

namespace Mediagone\Doctrine\Types\France\Business;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Mediagone\Types\France\Business\Tva;


final class TvaType extends Type
{
    //========================================================================================================
    // Properties
    //========================================================================================================
    
    public const NAME = 'france_tva';
    
    
    
    //========================================================================================================
    // Type implementation
    //========================================================================================================
    
    public function getName() : string
    {
        return self::NAME;
    }
    
    
    /**
     * Gets the SQL declaration snippet for a field of this type.
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) : string
    {
        return $platform->getVarcharTypeDeclarationSQL([
            'length' => Tva::LENGTH,
            'fixed' => true,
        ]);
    }
    
    
    /**
     * Adds an SQL comment to typehint the actual Doctrine Type for reverse schema engineering.
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }
    
    
    /**
     * Converts a value from its database representation to its PHP representation of this type.
     *
     * @param string|null $value The value to convert.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) : ?Tva
    {
        return $value !== null ? Tva::fromString($value) : null;
    }
    
    
    /**
     * Converts a value from its PHP representation to its database representation of this type.
     *
     * @param Tva|null $value The value to convert.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) : ?string
    {
        return $value ? (string)$value : null;
    }
    
    
    
}
