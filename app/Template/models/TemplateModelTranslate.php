

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class {module_class}Translate extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = '{module_convert}_translate';
    protected $fillable = ['{module_convert}_id','languages_id','name','content','description','meta_title','meta_desc','meta_keyword','meta_link'];

}
