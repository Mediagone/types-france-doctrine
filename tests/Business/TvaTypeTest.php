<?php declare(strict_types=1);

namespace Tests\Mediagone\Doctrine\Types\France\Business;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Platforms\PostgreSql94Platform;
use Doctrine\DBAL\Types\Type;
use Mediagone\Doctrine\Types\France\Business\TvaType;
use Mediagone\Types\France\Business\Tva;
use PHPUnit\Framework\TestCase;


/**
 * @covers \Mediagone\Doctrine\Types\France\Business\Tva
 */
final class TvaTypeTest extends TestCase
{
    //========================================================================================================
    // Properties
    //========================================================================================================
    
    private TvaType $type;
    
    
    
    //========================================================================================================
    // Initialization
    //========================================================================================================
    
    public static function setUpBeforeClass() : void
    {
        if (!Type::hasType(TvaType::NAME)) {
            Type::addType(TvaType::NAME, TvaType::class);
        }
    }
    
    
    public function setUp() : void
    {
        $this->type = Type::getType(TvaType::NAME);
    }
    
    
    
    //========================================================================================================
    // Tests
    //========================================================================================================
    
    public function test_can_return_its_name() : void
    {
        self::assertSame(TvaType::NAME, $this->type->getName());
    }
    
    
    public function test_requires_comment_hint() : void
    {
        self::assertTrue($this->type->requiresSQLCommentHint(new MySqlPlatform()));
        self::assertTrue($this->type->requiresSQLCommentHint(new PostgreSql94Platform()));
    }
    
    
    public function test_declare_sql() : void
    {
        self::assertSame('CHAR('.Tva::LENGTH.')', $this->type->getSQLDeclaration([], new MySqlPlatform()));
        self::assertSame('CHAR('.Tva::LENGTH.')', $this->type->getSQLDeclaration(['length' => '70'], new MySqlPlatform()));
        self::assertSame('CHAR('.Tva::LENGTH.')', $this->type->getSQLDeclaration(['length' => '200'], new MySqlPlatform()));
    }
    
    
    public function test_can_convert_to_database_value() : void
    {
        $tva = Tva::fromString('FR77523247930');
        $value = $this->type->convertToDatabaseValue($tva, new MySqlPlatform());
        
        self::assertSame($value, (string)$tva);
    }
    
    
    public function test_can_convert_value_from_database() : void
    {
        $value = 'FR77523247930';
        $tva = $this->type->convertToPHPValue($value, new MySqlPlatform());
        
        self::assertInstanceOf(Tva::class, $tva);
        self::assertSame($value, (string)$tva);
    }
    
    
    
}
