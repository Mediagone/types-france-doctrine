<?php declare(strict_types=1);

namespace Tests\Mediagone\Doctrine\Types\France\Geo;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Platforms\PostgreSql94Platform;
use Doctrine\DBAL\Types\Type;
use Mediagone\Doctrine\Types\France\Geo\PostalCodeType;
use Mediagone\Types\France\Geo\PostalCode;
use PHPUnit\Framework\TestCase;


/**
 * @covers \Mediagone\Doctrine\Types\France\Geo\PostalCode
 */
final class PostalCodeTypeTest extends TestCase
{
    //========================================================================================================
    // Properties
    //========================================================================================================
    
    private PostalCodeType $type;
    
    
    
    //========================================================================================================
    // Initialization
    //========================================================================================================
    
    public static function setUpBeforeClass() : void
    {
        if (!Type::hasType(PostalCodeType::NAME)) {
            Type::addType(PostalCodeType::NAME, PostalCodeType::class);
        }
    }
    
    
    public function setUp() : void
    {
        $this->type = Type::getType(PostalCodeType::NAME);
    }
    
    
    
    //========================================================================================================
    // Tests
    //========================================================================================================
    
    public function test_can_return_its_name() : void
    {
        self::assertSame(PostalCodeType::NAME, $this->type->getName());
    }
    
    
    public function test_requires_comment_hint() : void
    {
        self::assertTrue($this->type->requiresSQLCommentHint(new MySqlPlatform()));
        self::assertTrue($this->type->requiresSQLCommentHint(new PostgreSql94Platform()));
    }
    
    
    public function test_declare_sql() : void
    {
        self::assertSame('CHAR('.PostalCode::LENGTH.')', $this->type->getSQLDeclaration([], new MySqlPlatform()));
        self::assertSame('CHAR('.PostalCode::LENGTH.')', $this->type->getSQLDeclaration(['length' => '70'], new MySqlPlatform()));
        self::assertSame('CHAR('.PostalCode::LENGTH.')', $this->type->getSQLDeclaration(['length' => '200'], new MySqlPlatform()));
    }
    
    
    public function test_can_convert_to_database_value() : void
    {
        $code = PostalCode::fromString('12345');
        $value = $this->type->convertToDatabaseValue($code, new MySqlPlatform());
        
        self::assertSame($value, (string)$code);
    }
    
    
    public function test_can_convert_value_from_database() : void
    {
        $value = '12345';
        $code = $this->type->convertToPHPValue($value, new MySqlPlatform());
        
        self::assertInstanceOf(PostalCode::class, $code);
        self::assertSame($value, (string)$code);
    }
    
    
    
}
