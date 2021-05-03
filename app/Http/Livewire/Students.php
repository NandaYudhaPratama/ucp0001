<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;

class Students extends Component
{
   public $students, $nama, $nim, $alamat, $student_id;
    public $isOpen = 0;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $this->students = Student::all();
        return view('livewire.students');
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->nama = '';
        $this->nim = '';
        $this->alamat = '';
        $this->student_id = '';
    }
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'nim' => 'required',
            'alamat' => 'required',
        ]);
   
        Student::updateOrCreate(['id' => $this->student_id], [
            'nama' => $this->nama,
            'nim' => $this->nim,
            'alamat' => $this->alamat
        ]);
  
        session()->flash('message', 
            $this->student_id ? 'Student Updated Successfully.' : 'Student Created Successfully.');
  
        $this->closeModal();
        $this->resetInputFields();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $this->student_id = $id;
        $this->nama = $student->nama;
        $this->nim = $student->nim;
        $this->alamat = $student->alamat;
    
        $this->openModal();
    }
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Student::find($id)->delete();
        session()->flash('message', 'Student Deleted Successfully.');
    }
}

?>