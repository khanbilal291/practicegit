<?php
class Employee
{
    private $id;
    private $name;
    private $salary;

    public function __construct($id, $name, $salary)
    {
        $this->id = $id;
        $this->name = $name;
        $this->salary = $salary;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSalary()
    {
        return $this->salary;
    }
}

class Department
{
    private $name;
    private $employees = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addEmployee($employee)
    {
        $this->employees[] = $employee;
    }

    public function getEmployees()
    {
        return $this->employees;
    }

    public function getTotalSalary()
    {
        $total = 0;
        foreach ($this->employees as $employee) {
            $total += $employee->getSalary();
        }
        return $total;
    }

    public function getName()
    {
        return $this->name;
    }
}

class Company
{
    private $name;
    private $departments = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addDepartment($department)
    {
        $this->departments[] = $department;
    }

    public function getDepartments()
    {
        return $this->departments;
    }
}

$company = new Company("TechCorp");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_department"]) && !empty($_POST["department_name"])) {
        $department = new Department($_POST["department_name"]);
        $company->addDepartment($department);
    }

    if (isset($_POST["add_employee"]) && isset($_POST["department_index"]) && !empty($_POST["employee_name"]) && !empty($_POST["employee_salary"])) {
        $employee = new Employee(count($company->getDepartments()) + 1, $_POST["employee_name"], $_POST["employee_salary"]);
        $departmentIndex = $_POST["department_index"];
        if ($departmentIndex >= 0 && $departmentIndex < count($company->getDepartments())) {
            $department = $company->getDepartments()[$departmentIndex];
            $department->addEmployee($employee);
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Company Organizational Structure</title>
</head>

<body>
    <h1>Company Organizational Structure</h1>

    <h2>Add Department</h2>
    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        <input type="text" name="department_name" placeholder="Department Name" required>
        <input type="submit" name="add_department" value="Add Department">
    </form>

    <h2>Add Employee</h2>
    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
        <select name="department_index">
            <?php
            foreach ($company->getDepartments() as $index => $department) {
                echo "<option value='$index'>" . $department->getName() . "</option>";
            }
            ?>
        </select>
        <input type="text" name="employee_name" placeholder="Employee Name" required>
        <input type="number" name="employee_salary" placeholder="Employee Salary" required>
        <input type="submit" name="add_employee" value="Add Employee">
    </form>

    <h2>Company Structure</h2>
    <?php
    $departments = $company->getDepartments();
    foreach ($departments as $department) {
        echo "<h3>" . $department->getName() . "</h3>";
        $employees = $department->getEmployees();
        if (count($employees) === 0) {
            echo "<p>No employees in this department.</p>";
        } else {
            echo "<ul>";
            foreach ($employees as $employee) {
                echo "<li>" . $employee->getName() . " (Salary: $" . $employee->getSalary() . ")</li>";
            }
            echo "</ul>";
        }
    }
    ?>
</body>

</html>