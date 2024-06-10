
namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
class {module_class}Cateloge extends Model
{
    use HasFactory;
    use SoftDeletes,QueryScopes,NodeTrait;
    
    protected $table = '{moduleTable}';
    protected $primaryKey = 'id';
    //dạng fillable mặc định cho model cataloge
    protected $fillable = ['image','icon','album','status','order','user_id','follow','parent','LEFT','RIGHT'];
    

    public function languages() {
        return $this->belongsToMany(Languages::class,"{module}_cateloge_translate","{module}_cataloge_id",'languages_id')
        ->withPivot(['name','content','desc','meta_title','meta_keyword','meta_desc','meta_link'])->withTimestamps();
    }

    public function {module}_cateloge_translate() {
        return $this->belongsTo({module_class}CatelogeTranslate::class,"{module}_cataloge_id",'id');
    }

    public function getLftName()
    {
        return 'LEFT';
    }

    public function getRgtName()
    {
        return 'RIGHT';
    }

    public function getParentIdName()
    {
        return 'parent';
    }

    // Specify parent id attribute mutator
    public function setParentAttribute($value)
    {
        $this->setParentIdAttribute($value);   
    }
}