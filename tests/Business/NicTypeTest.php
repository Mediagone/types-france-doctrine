<?php declare(strict_types=1);

namespace Tests\Mediagone\Doctrine\Types\France\Business;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Platforms\PostgreSql94Platform;
use Doctrine\DBAL\Types\Type;
use Mediagone\Doctrine\Types\France\Business\NicType;
use Mediagone\Types\France\Business\Nic;
use PHPUnit\Framework\TestCase;


/**
 * @covers \Mediagone\Doctrine\Types\France\Business\Nic
 */
final class NicTypeTest extends TestCase
{
    //========================================================================================================
    // Properties
    //========================================================================================================
    
    private NicType $type;
    
    
    
    //========================================================================================================
    // Initialization
    //========================================================================================================
    
    public static function setUpBeforeClass() : void
    {
        if (!Type::hasType(NicType::NAME)) {
            Type::addType(NicType::NAME, NicType::class);
        }
    }
    
    
    public function setUp() : void
    {
        $this->type = Type::getType(NicType::NAME);
    }
    
    
    
    //========================================================================================================
    // Tests
    //========================================================================================================
    
    public function test_can_return_its_name() : void
    {
        self::assertSame(NicType::NAME, $this->type->getName());
    }
    
    
    public function test_requires_comment_hint() : void
    {
        self::assertTrue($this->type->requiresSQLCommentHint(new MySqlPlatform()));
        self::assertTrue($this->type->requiresSQLCommentHint(new PostgreSql94Platform()));
    }
    
    
    public function test_declare_sql() : void
    {
        self::assertSame('CHAR('.Nic::LENGTH.')', $this->type->getSQLDeclaration([], new MySqlPlatform()));
        self::assertSame('CHAR('.Nic::LENGTH.')', $this->type->getSQLDeclaration(['length' => '70'], new MySqlPlatform()));
        self::assertSame('CHAR('.Nic::LENGTH.')', $this->type->getSQLDeclaration(['length' => '200'], new MySqlPlatform()));
    }
    
    
    public function test_can_convert_to_database_value() : void
    {
        $nic = Nic::fromString('12345');
        $value = $this->type->convertToDatabaseValue($nic, new MySqlPlatform());
        
        self::assertSame($value, (string)$nic);
    }
    
    
    public function test_can_convert_value_from_database() : void
    {
        $value = '12345';
        $nic = $this->type->convertToPHPValue($value, new MySqlPlatform());
        
        self::assertInstanceOf(Nic::class, $nic);
        self::assertSame($value, (string)$nic);
    }
    
    
    
}
