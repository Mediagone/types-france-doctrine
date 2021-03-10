<?php declare(strict_types=1);

namespace Tests\Mediagone\Doctrine\Types\France\Business;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Platforms\PostgreSql94Platform;
use Doctrine\DBAL\Types\Type;
use Mediagone\Doctrine\Types\France\Business\SirenType;
use Mediagone\Types\France\Business\Siren;
use PHPUnit\Framework\TestCase;


/**
 * @covers \Mediagone\Doctrine\Types\France\Business\Siren
 */
final class SirenTypeTest extends TestCase
{
    //========================================================================================================
    // Properties
    //========================================================================================================
    
    private SirenType $type;
    
    
    
    //========================================================================================================
    // Initialization
    //========================================================================================================
    
    public static function setUpBeforeClass() : void
    {
        if (!Type::hasType(SirenType::NAME)) {
            Type::addType(SirenType::NAME, SirenType::class);
        }
    }
    
    
    public function setUp() : void
    {
        $this->type = Type::getType(SirenType::NAME);
    }
    
    
    
    //========================================================================================================
    // Tests
    //========================================================================================================
    
    public function test_can_return_its_name() : void
    {
        self::assertSame(SirenType::NAME, $this->type->getName());
    }
    
    
    public function test_requires_comment_hint() : void
    {
        self::assertTrue($this->type->requiresSQLCommentHint(new MySqlPlatform()));
        self::assertTrue($this->type->requiresSQLCommentHint(new PostgreSql94Platform()));
    }
    
    
    public function test_declare_sql() : void
    {
        self::assertSame('CHAR('.Siren::LENGTH.')', $this->type->getSQLDeclaration([], new MySqlPlatform()));
        self::assertSame('CHAR('.Siren::LENGTH.')', $this->type->getSQLDeclaration(['length' => '70'], new MySqlPlatform()));
        self::assertSame('CHAR('.Siren::LENGTH.')', $this->type->getSQLDeclaration(['length' => '200'], new MySqlPlatform()));
    }
    
    
    public function test_can_convert_to_database_value() : void
    {
        $siren = Siren::fromString('123456789');
        $value = $this->type->convertToDatabaseValue($siren, new MySqlPlatform());
        
        self::assertSame($value, (string)$siren);
    }
    
    
    public function test_can_convert_value_from_database() : void
    {
        $value = '123456789';
        $siren = $this->type->convertToPHPValue($value, new MySqlPlatform());
        
        self::assertInstanceOf(Siren::class, $siren);
        self::assertSame($value, (string)$siren);
    }
    
    
    
}
