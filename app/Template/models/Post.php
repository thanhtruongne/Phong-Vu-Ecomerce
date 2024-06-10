namespace App\Models;

use App\Trait\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class {module_class} extends Model
{
    use HasFactory;
    use SoftDeletes,QueryScopes;
    protected $table = '{moduleTable}';
    protected $primaryKey = 'id';
    protected $fillable = ['image','icon','album','status','order','user_id','follow','{module}_cateloge_id'];
    

    public function {module}_cataloge() {
        return $this->belongsTo({module_class}Cataloge::class,'{module}_cateloge_id','id');
    }

    public function {module}_translate() {
        return $this->hasOne({module_class}Transltate::class,'{module}_id','id');
    }

    public function languages() {
        return $this->belongsToMany(Languages::class,'{module}_translate','{module}_id','language_id')
        ->withPivot(['name','content','desc','meta_title','meta_keyword','meta_desc','meta_link'])->withTimestamps();
    }

    public function {module}_cataloge_{module}() {
        return $this->belongsToMany({module_class}Cataloges::class,'{module}_cataloge_{module}','{module}_id','{module}_cateloge_id');
    }

}

