<?php declare(strict_types=1);

namespace Tests\Mediagone\Doctrine\Types\France\Business;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Platforms\PostgreSql94Platform;
use Doctrine\DBAL\Types\Type;
use Mediagone\Doctrine\Types\France\Business\SiretType;
use Mediagone\Types\France\Business\Siret;
use PHPUnit\Framework\TestCase;


/**
 * @covers \Mediagone\Doctrine\Types\France\Business\Siret
 */
final class SiretTypeTest extends TestCase
{
    //========================================================================================================
    // Properties
    //========================================================================================================
    
    private SiretType $type;
    
    
    
    //========================================================================================================
    // Initialization
    //========================================================================================================
    
    public static function setUpBeforeClass() : void
    {
        if (!Type::hasType(SiretType::NAME)) {
            Type::addType(SiretType::NAME, SiretType::class);
        }
    }
    
    
    public function setUp() : void
    {
        $this->type = Type::getType(SiretType::NAME);
    }
    
    
    
    //========================================================================================================
    // Tests
    //========================================================================================================
    
    public function test_can_return_its_name() : void
    {
        self::assertSame(SiretType::NAME, $this->type->getName());
    }
    
    
    public function test_requires_comment_hint() : void
    {
        self::assertTrue($this->type->requiresSQLCommentHint(new MySqlPlatform()));
        self::assertTrue($this->type->requiresSQLCommentHint(new PostgreSql94Platform()));
    }
    
    
    public function test_declare_sql() : void
    {
        self::assertSame('CHAR('.Siret::LENGTH.')', $this->type->getSQLDeclaration([], new MySqlPlatform()));
        self::assertSame('CHAR('.Siret::LENGTH.')', $this->type->getSQLDeclaration(['length' => '70'], new MySqlPlatform()));
        self::assertSame('CHAR('.Siret::LENGTH.')', $this->type->getSQLDeclaration(['length' => '200'], new MySqlPlatform()));
    }
    
    
    public function test_can_convert_to_database_value() : void
    {
        $siret = Siret::fromString('12345678901234');
        $value = $this->type->convertToDatabaseValue($siret, new MySqlPlatform());
        
        self::assertSame($value, (string)$siret);
    }
    
    
    public function test_can_convert_value_from_database() : void
    {
        $value = '12345678901234';
        $siret = $this->type->convertToPHPValue($value, new MySqlPlatform());
        
        self::assertInstanceOf(Siret::class, $siret);
        self::assertSame($value, (string)$siret);
    }
    
    
    
}
