{!! "<"."?php" !!}

namespace App\Repositories;

class {{ $name }} extends EloquentRepository
{
    /**
     * Return an elqouent model instance.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function model()
    {
        return new \App\Model;
    }
}
